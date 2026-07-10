<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CreateWine extends Controller
{
    public function newWineSubmit(Request $request)
    {
        Gate::authorize('addNewWine', User::class);

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
        $product->code = $request->code;

        $product->save();

        return redirect()->route('index');
    }
}
