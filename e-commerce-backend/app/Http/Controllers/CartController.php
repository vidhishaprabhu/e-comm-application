<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
   public function index(Request $request)
{
    $user = $request->user(); // already the User model instance

    return response()->json(
        $user->cart()->with('product')->get()
    );
}

   public function add(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = $request->user();

        $cartitem = Cart::firstOrCreate(
            ['user_id' => $user->id, 'product_id' => $request->product_id],
            ['quantity' => 0]
        );

        $cartitem->increment('quantity');

        return response()->json(['message' => 'Added to cart']);
    }

    public function remove(Request $request, $productId)
{
    $cartItem = $request->user()->cart()->where('product_id', $productId)->first();

    if (!$cartItem) {
        return response()->json(['message' => 'Item not found in cart'], 404);
    }

    if ($cartItem->quantity > 1) {
        $cartItem->quantity -= 1;
        $cartItem->save();
    } else {
        $cartItem->delete();
    }

    return response()->json(['message' => 'Item quantity updated or removed']);
}

}
