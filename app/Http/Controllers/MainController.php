<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $products = Products::all();
        return view('catalog.catalog', compact('products'));
    }

    public function newWine()
    {
        return view('catalog.create');
    }
}
