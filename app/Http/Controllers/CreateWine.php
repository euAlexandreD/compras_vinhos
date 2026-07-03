<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class CreateWine extends Controller
{
    public function newWineSubmit(Request $request)
    {
        $id = session('user.id');
        $product = new Products();
        $product->name_wine = $request->name_wine;
        $product->type = $request->type;
        $product->harvest = $request->harvest;
        $product->country = $request->country;
        $product->region = $request->region;
        $product->grape = $request->grape;
        $product->alcohol_content = $request->alcohol_content;
        $product->temperature = $request->temperature;
        $product->observation = $request->observation;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->code = $request->vocodelume;

        $product->save();

        return redirect()->route('index');
    }
}
