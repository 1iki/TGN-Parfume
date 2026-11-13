<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Handle POST requests to cart.php for update/delete or GET delete_all
        if ($request->isMethod('post')) {
            if ($request->has('delete')) {
                $cartId = $request->input('cart_id');
                return $this->remove($cartId);
            }
            if ($request->has('update_qty')) {
                $cartId = $request->input('cart_id');
                return $this->update($request, $cartId);
            }
            if ($request->has('add_to_cart')) {
                return $this->add($request);
            }
        }

        if ($request->has('delete_all')) {
            Cart::where('user_id', $userId)->delete();
            return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil dikosongkan.');
        }

        $cartItems = Cart::where('user_id', $userId)->get();
        $grandTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'grandTotal'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id') ?? $request->input('pid');
        $quantity = (int)($request->input('quantity') ?? $request->input('qty', 1));

        if (empty($productId)) {
            return back()->with('error', 'ID produk tidak valid.');
        }

        $product = Product::find($productId);
        if (!$product && is_numeric($productId)) {
            $product = Product::where('legacy_id', (int)$productId)->first();
        }
        if (!$product && $request->has('name')) {
            $product = Product::where('name', $request->input('name'))->first();
        }

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        $userId = Auth::id();

        // Check if item already exists in cart for user by pid or name
        $existingCart = Cart::where('user_id', $userId)
            ->where(function ($q) use ($product) {
                $q->where('pid', (string)$product->_id)
                  ->orWhere('pid', (int)($product->legacy_id ?? 0))
                  ->orWhere('name', $product->name);
            })->first();

        if ($existingCart) {
            $existingCart->quantity = (int)$existingCart->quantity + $quantity;
            $existingCart->save();
            return back()->with('success', 'Jumlah produk di keranjang telah diperbarui!');
        }

        Cart::create([
            'user_id' => $userId,
            'pid' => (string)$product->_id,
            'name' => $product->name,
            'price' => (int)$product->price,
            'quantity' => $quantity,
            'image' => trim($product->image),
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $quantity = (int)($request->input('quantity') ?? $request->input('qty', 1));
        $userId = Auth::id();

        $cartItem = Cart::where('user_id', $userId)
            ->where(function ($query) use ($id) {
                $query->where('_id', $id)
                    ->orWhere('legacy_id', (int)$id);
            })->first();

        if (!$cartItem) {
            $cartItem = Cart::where('user_id', $userId)->first();
        }

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
            return back()->with('success', 'Jumlah pesanan berhasil diperbarui.');
        }

        return back()->with('error', 'Item keranjang tidak ditemukan.');
    }

    public function remove($id)
    {
        $userId = Auth::id();

        Cart::where('user_id', $userId)
            ->where(function ($query) use ($id) {
                $query->where('_id', $id)
                    ->orWhere('legacy_id', (int)$id);
            })->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        $userId = Auth::id();
        Cart::where('user_id', $userId)->delete();
        return back()->with('success', 'Keranjang belanja berhasil dikosongkan.');
    }
}
