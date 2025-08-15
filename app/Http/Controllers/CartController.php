<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        return view('keranjang', compact('cart'));
    }

    public function store(Request $request, Product $product)
    {
        // Validasi stok
        if ($product->stok < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis'
            ], 400);
        }

        $cart = $this->getCart();
        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + ($request->quantity ?? 1);

            if ($newQuantity > $product->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah melebihi stok'
                ], 400);
            }

            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
                'price' => $product->harga
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ditambahkan ke keranjang',
            'cartCount' => $cart->items()->sum('quantity')
        ]);
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->product->stok
        ]);

        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui');
    }

    public function destroy(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }

    private function getCart()
    {
        $sessionId = session()->get('cart_session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
            session()->put('cart_session_id', $sessionId);
        }
        return Cart::with(['items.product'])->firstOrCreate(['session_id' => $sessionId]);
    }
}
