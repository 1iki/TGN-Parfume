<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('pid')) {
            return $this->show($request->input('pid'));
        }

        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where(function ($query) use ($id) {
                $query->where('_id', $id)
                    ->orWhere('legacy_id', (int)$id);
            })->first();

        if (!$order && Auth::check() && (Auth::user()->level === '1' || Auth::user()->role === 'admin' || Auth::user()->level === 'admin')) {
            $order = Order::where('_id', $id)
                ->orWhere('legacy_id', (int)$id)
                ->first();
        }

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong! Silakan pilih produk terlebih dahulu.');
        }

        $grandTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $user = Auth::user();

        return view('orders.checkout', compact('cartItems', 'grandTotal', 'user'));
    }

    public function store(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        // Handle both legacy checkout form input fields and standard fields
        if ($request->has('firstname')) {
            $name = trim($request->input('firstname') . ' ' . $request->input('lastname'));
        } else {
            $name = $request->input('name', Auth::user()->fullname ?? Auth::user()->username);
        }

        $number = $request->input('number') ?? $request->input('phone', Auth::user()->phone ?? '0000000000');
        $email = $request->input('email', Auth::user()->email);

        $methodInput = $request->input('method', 'credit');
        if ($request->has('cc-name')) {
            $method = $methodInput . ' - ' . $request->input('cc-name') . ', ' . $request->input('cc-number') . ', ' . $request->input('cc-expiration') . ', ' . $request->input('cc-cvv');
        } else {
            $method = $methodInput;
        }

        if ($request->has('address') && $request->has('city')) {
            $address = $request->input('address') . ', ' . $request->input('city') . ', ' . $request->input('country') . ' - ' . $request->input('zip');
        } elseif ($request->has('flat')) {
            $address = 'No. ' . $request->input('flat') . ', ' . $request->input('street') . ', ' . $request->input('city') . ', ' . $request->input('state') . ', ' . $request->input('country') . ' - ' . $request->input('pin_code');
        } else {
            $address = $request->input('address', Auth::user()->address ?? 'Alamat Pengiriman');
        }

        $address2 = $request->input('address2', '');

        $totalProducts = [];
        $grandTotal = 0;

        foreach ($cartItems as $item) {
            $totalProducts[] = $item->name . ' (' . number_format($item->price, 0, ',', '.') . ' x ' . $item->quantity . ')';
            $grandTotal += ($item->price * $item->quantity);

            // Increment sold count for each product
            $product = Product::find($item->pid);
            if (!$product) {
                $product = Product::where('legacy_id', (int)$item->pid)->first();
            }
            if ($product) {
                $product->increment('sold', $item->quantity);
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'method' => $method,
            'address' => $address,
            'address2' => $address2,
            'total_products' => implode(' - ', $totalProducts),
            'total_price' => $grandTotal,
            'placed_on' => now()->format('Y-m-d'),
            'payment_status' => 'Pending',
        ]);

        // Empty user cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan Anda telah berhasil dibuat! Terima kasih telah berbelanja.');
    }
}
