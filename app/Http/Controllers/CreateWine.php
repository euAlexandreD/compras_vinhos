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
        ]);

        $id = session('user.id');
        $product = new Products();
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

        foreach ($request->file('images', []) as $index => $file) {
            $path = $file->store('products', 'public');

            $product->images()->create([
                'path' => $path,
                'is_primary' => $index === 0,
                'position' => $index,
            ]);
        }

        return redirect()->route('index');
    }
}
