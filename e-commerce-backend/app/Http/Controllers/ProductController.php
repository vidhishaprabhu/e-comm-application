<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    if ($request->has('category')) {
        $category = $request->input('category');

        if ($category === 'All') {
            $products = Product::all();
        } else {
            $products = Product::whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            })->get();
        }
    } else {
        $products = Product::all();
    }

    return response()->json($products);
}


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}
