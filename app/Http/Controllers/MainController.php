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

class MainController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::query();
        $products->when($request->keyword, function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name_wine', 'ilike', "%{$keyword}%")
                    ->orWhere('type', 'ilike', "%{$keyword}%")
                    ->orWhere('grape', 'ilike', "%{$keyword}%");
            });
        });

        $products = $products->paginate();

        return view('catalog.catalog', compact('products'));
    }

    public function newWine()
    {
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
        return redirect()->route('orders');
    }

    public function orders(Request $request)
    {
        $orders = Orders::with(['user', 'status', 'items.product'])
            ->when($request->status_id, function ($query, $statusId) {
                $query->where('status_id', $statusId);
            })
            ->latest()
            ->paginate(10);

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
        $product = Products::findOrFail($id);
        return view('catalog.edit', compact('product'));
    }

    public function ordersPdf(Request $request)
    {
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
}
