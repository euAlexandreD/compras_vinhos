<?php

namespace App\Http\Controllers;

use App\Models\OrdemItem;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Statuses;
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
        $product = Products::findOrFail($request->product_id);

        // if($request->quantity > $product->quantity)

        $cart = session()->get('cart', []);

        foreach ($request->products as $productId) {
            if ($product->quantity <= 0) {
                continue;
            }

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += 1;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name_wine,
                    'price' => $product->price,
                    'quantity' => 1,
                ];
            }
        }

        session()->put('cart', $cart);
        return redirect()->route('cart');
        // return redirect()->route()
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
}
