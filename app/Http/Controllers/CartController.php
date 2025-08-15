<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $cart = Auth::user()->cart()->with(['items.product'])->firstOrCreate();
        return view('keranjang', compact('cart'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:' . $product->stok
        ]);

        if ($product->stok < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis'
            ], 400);
        }

        $cart = Auth::user()->cart()->firstOrCreate();
        $quantity = $request->quantity ?? 1;

        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            if ($newQuantity > $product->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah melebihi stok yang tersedia'
                ], 400);
            }

            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->harga
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cartCount' => $cart->refresh()->total_items
        ]);
    }

    public function update(Request $request, CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->product->stok
        ]);

        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui');
    }

    public function destroy(CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $item->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}
