<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ImageCompressionService;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%")
                  ->orWhere('ingredient', 'like', "%{$search}%");
        }

        $products = $query->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return redirect()->route('admin.products.index');
    }

    public function store(Request $request, ImageCompressionService $imageService)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'details' => 'required|string|max:1000',
                'categories' => 'required|string|in:male,female',
                'ingredient' => 'required|string|max:200',
                'price' => 'required|numeric|min:0',
                'image' => 'required|file|mimes:jpeg,png,jpg,webp,gif',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()
                ->with(['form_mode' => 'create', 'form_id' => '']);
        }

        $result = $imageService->compressAndSave($request->file('image'), public_path('uploaded_img'));
        if (!$result['success']) {
            return back()->withErrors(['image' => $result['error']])->withInput()
                ->with(['form_mode' => 'create', 'form_id' => '']);
        }

        $imageName = $result['filename'];

        Product::create([
            'name' => $validated['name'],
            'details' => $validated['details'],
            'categories' => strtolower($validated['categories']),
            'ingredient' => $validated['ingredient'],
            'price' => (int)$validated['price'],
            'image' => $imageName,
            'sold' => 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk parfum baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        return redirect()->route('admin.products.index');
    }

    public function update(Request $request, $id, ImageCompressionService $imageService)
    {
        $product = Product::findOrFail($id);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'details' => 'required|string|max:1000',
                'categories' => 'required|string|in:male,female',
                'ingredient' => 'required|string|max:200',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()
                ->with(['form_mode' => 'edit', 'form_id' => $id]);
        }

        $updateData = [
            'name' => $validated['name'],
            'details' => $validated['details'],
            'categories' => strtolower($validated['categories']),
            'ingredient' => $validated['ingredient'],
            'price' => (int)$validated['price'],
        ];

        if ($request->hasFile('image')) {
            $result = $imageService->compressAndSave($request->file('image'), public_path('uploaded_img'));
            if (!$result['success']) {
                return back()->withErrors(['image' => $result['error']])->withInput()
                    ->with(['form_mode' => 'edit', 'form_id' => $id]);
            }
            $updateData['image'] = $result['filename'];
        }

        $product->update($updateData);

        return redirect()->route('admin.products.index')->with('success', 'Data produk parfum berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk parfum berhasil dihapus.');
    }
}
