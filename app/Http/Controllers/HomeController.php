<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $maleProducts = Product::where('categories', 'male')->take(6)->get();
            $femaleProducts = Product::where('categories', 'female')->take(6)->get();
            $latestProducts = Product::latest()->take(8)->get();
        } catch (\Throwable $e) {
            $maleProducts = collect();
            $femaleProducts = collect();
            $latestProducts = collect();
        }

        return view('home', compact('maleProducts', 'femaleProducts', 'latestProducts'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $products = [];

        if ($query) {
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('details', 'like', "%{$query}%")
                ->orWhere('categories', 'like', "%{$query}%")
                ->orWhere('ingredient', 'like', "%{$query}%")
                ->get();
        }

        return view('search', compact('products', 'query'));
    }
}
