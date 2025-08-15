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
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stok
        ]);

        $cart = $this->getCart();

        // Cek apakah produk sudah ada di keranjang
        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->product->stok
        ]);

        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah produk berhasil diupdate');
    }

    public function destroy(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    private function getCart()
    {
        $sessionId = session()->get('cart_session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
            session()->put('cart_session_id', $sessionId);
        }
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }
}
