<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(?Request $request = null)
    {
        $request = $request ?? request();
        $category = $request->query('category');

        if ($category) {
            $products = Product::where('categories', strtolower($category))->get();
        } else {
            $products = Product::all();
        }

        return view('products.index', compact('products', 'category'));
    }

    public function show($id)
    {
        $product = Product::where('id', (int)$id)
            ->orWhere('legacy_id', (int)$id)
            ->orWhere('_id', $id)
            ->first();

        if (!$product) {
            abort(404, 'Parfum tidak ditemukan.');
        }

        return view('products.show', compact('product'));
    }
}
