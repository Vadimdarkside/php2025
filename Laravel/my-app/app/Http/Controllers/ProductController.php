<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all(); 
    }

    public function store(Request $request)
    {
        $product = Product::create($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]));

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]));

        return response()->json($product);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
