<?php
//app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        if ($product->quantity < $request->quantity) {
            return response()->json(['message' => 'Product not available in the requested quantity'], 400);
        }

        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user_id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json($cart);
    }

    public function viewCart($userId)
    {
        $cart = Cart::where('user_id', $userId)->with('product')->get();

        $totalPrice = $cart->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json(['cart' => $cart, 'total_price' => $totalPrice]);
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($id);
        $product = Product::find($cartItem->product_id);

        if ($product->quantity < $request->quantity) {
            return response()->json(['message' => 'Product not available in the requested quantity'], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json($cartItem);
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }
}
