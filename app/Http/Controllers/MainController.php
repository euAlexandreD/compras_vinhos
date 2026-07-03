<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

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
}
