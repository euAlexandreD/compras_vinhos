<?php

namespace App\Http\Controllers;

use App\Models\OrdemItem;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Statuses;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::query()->with('primaryImage');
        $products->when($request->keyword, function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name_wine', 'ilike', "%{$keyword}%")
                    ->orWhere('type', 'ilike', "%{$keyword}%")
                    ->orWhere('grape', 'ilike', "%{$keyword}%");
            });
        });

        $products = $products->paginate(5);

        return view('catalog.catalog', compact('products'));
    }

    public function newWine()
    {
        Gate::authorize('addNewWine', User::class);
        return view('catalog.create');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }


    public function addToCart(Request $request)
    {
        $products = collect($request->products)
            ->filter(fn($quantity) => (int) $quantity > 0);

        if ($products->isEmpty()) {
            return back()->with('error', 'Selecione pelo menos um produto.');
        }

        $cart = session()->get('cart', []);

        foreach ($products as $productId => $quantity) {
            $product = Products::findOrFail($productId);
            $quantity = (int) $quantity;


            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name_wine,
                    'price' => $product->price,
                    'quantity' => $quantity,
                ];
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart');
    }


    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Carrinho vazio.');
        }

        DB::transaction(function () use ($cart) {
            $order = Orders::create([
                'user_id' => session('user.id'),
                'status_id' => 1,
                'total_price' => 0,
            ]);

            $total = 0;

            foreach ($cart as $item) {
                $product = Products::findOrFail($item['id']);

                $subtotal = $item['quantity'] * $product->price;

                OrdemItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->quantity -= $item['quantity'];
                $product->save();
                $total += $subtotal;
            }

            $order->total_price = $total;
            $order->save();
        });

        session()->forget('cart');

        return redirect()->route('myOrders')->with('success', 'Pedido realizado com sucesso!');
    }

    public function orders(Request $request)
    {
        Gate::authorize('viewOrders', User::class);

        $orders = Orders::with(['user', 'status', 'items.product'])
            ->when($request->status_id, function ($query, $statusId) {
                $query->where('status_id', $statusId);
            })
            ->latest()
            ->paginate(5);

        $statuses = Statuses::all();

        return view('orders.index', compact('orders', 'statuses'));
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        unset($cart[$request->product_id]);

        session()->put('cart', $cart);

        return redirect()->route('cart');
    }

    public function clearCart()
    {
        session()->forget('cart');

        return redirect()->route('cart')
            ->with('success', 'Carrinho limpo com sucesso.');
    }

    public function editProduct($id)
    {
        Gate::authorize('editWine', User::class);
        $product = Products::findOrFail($id)->load('images');
        return view('catalog.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        Gate::authorize('editWine', User::class);

        $product = Products::findOrFail($id);

        $request->validate([
            'name_wine' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'harvest' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'volume' => ['nullable', 'string', 'max:255'],
            'observation' => ['nullable', 'string'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'code' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['image', 'max:2048'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer'],
        ]);

        $product->name_wine = $request->name_wine;
        $product->type = $request->type;
        $product->harvest = $request->harvest;
        $product->country = $request->country;
        $product->volume = $request->volume;
        $product->observation = $request->observation;
        $product->quantity = $request->quantity ?? 0;
        $product->price = $request->price ?? 0;
        $product->code = $request->code;
        $product->save();

        $imagesToRemove = $product->images()
            ->whereIn('id', $request->input('remove_images', []))
            ->get();

        foreach ($imagesToRemove as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $newFiles = $request->file('images', []);

        if (!empty($newFiles)) {
            $nextPosition = (int) $product->images()->max('position') + 1;
            $hasPrimary = $product->images()->where('is_primary', true)->exists();

            foreach ($newFiles as $index => $file) {
                $path = $file->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                    'is_primary' => !$hasPrimary && $index === 0,
                    'position' => $nextPosition + $index,
                ]);
            }
        }

        return redirect()->route('index')->with('success', 'Vinho atualizado com sucesso.');
    }

    public function ordersPdf(Request $request)
    {
        Gate::authorize('viewOrders', User::class);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $users = User::with(['orders' => function ($query) use ($startDate, $endDate) {
            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $query->with(['items.product']);
        }])
            ->whereHas('orders', function ($query) use ($startDate, $endDate) {
                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }

                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }
            })
            ->orderBy('username')
            ->get();

        $pdf = Pdf::loadView('catalog.pdf', compact('users', 'startDate', 'endDate'));

        return $pdf->download('relatorio_pedidos_por_cliente.pdf');
    }

    public function ordersBottlesPdf(Request $request)
    {
        Gate::authorize('viewOrders', User::class);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $items = OrdemItem::query()
            ->select('product_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(subtotal) as total_value')
            ->with('product')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }

                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }
            })
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->get();

        $totalBottles = $items->sum('total_quantity');
        $totalValue = $items->sum('total_value');

        $pdf = Pdf::loadView('orders.report_bottles', compact('items', 'startDate', 'endDate', 'totalBottles', 'totalValue'));

        return $pdf->download('relatorio_garrafas_pedidas.pdf');
    }

    public function myOrders()
    {
        $orders = Orders::with(['items.product', 'status'])
            ->where('user_id', session('user.id'))
            ->latest()
            ->paginate(10);

        return view('orders.my_orders', compact('orders'));
    }

    public function repeatOrder($id)
    {
        $order = Orders::with('items.product')
            ->where('user_id', session('user.id'))
            ->findOrFail($id);

        $cart = session()->get('cart', []);

        foreach ($order->items as $item) {
            $product = $item->product;

            if (!$product) {
                continue;
            }

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $item->quantity;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name_wine,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                ];
            }
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart')
            ->with('success', 'Pedido adicionado ao carrinho novamente.');
    }
}
