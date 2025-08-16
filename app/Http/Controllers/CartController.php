<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return DB::transaction(function () use ($request, $product) {
            $cart = Auth::user()->cart()->firstOrCreate();
            $quantity = $request->quantity ?? 1;

            // Lock produk untuk mencegah race condition
            $product = Product::lockForUpdate()->find($product->id);

            if ($quantity > $product->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah melebihi stok yang tersedia'
                ], 400);
            }

            $existingItem = $cart->items()->where('product_id', $product->id)->first();

            if ($existingItem) {
                $newQuantity = $existingItem->quantity + $quantity;
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
        });
    }

    public function update(Request $request, CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
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
            abort(403, 'Akses tidak diizinkan.');
        }

        $item->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function confirm(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $cart = Auth::user()->cart()->with(['items.product' => function($q) {
                $q->lockForUpdate();
            }])->first();

            if (!$cart || $cart->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang belanja kosong'
                ], 400);
            }

            $request->validate([
                'customer_name' => 'required|string|max:255',
                'pgtpq' => 'required|string|max:255',
                'address' => 'required|string',
                'notes' => 'nullable|string'
            ]);

            // Validasi stok sebelum checkout
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stok) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok tidak mencukupi untuk produk: ' . $item->product->judul
                    ], 400);
                }
            }

            // Kurangi stok
            foreach ($cart->items as $item) {
                $item->product->decrement('stok', $item->quantity);
            }

            // Kosongkan keranjang
            $cart->items()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikonfirmasi'
            ]);
        });
    }

    public function thankYou()
    {
        return view('thankyou');
    }
}
