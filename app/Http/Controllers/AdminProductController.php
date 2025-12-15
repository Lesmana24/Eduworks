<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('admin.products.create', compact('categories'));
    }

    // --- STORE (SIMPAN) ---
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // INI KUNCINYA: Kita taruh di public/storage/products
            $path = public_path('storage/products');

            // Buat folder otomatis kalau belum ada (jaga-jaga)
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Pindahkan file
            $file->move($path, $filename);

            // Simpan di DB tetap 'products/namafile.jpg'
            // Supaya pas dipanggil asset('storage/' . $product->image) hasilnya PAS
            $data['image'] = 'products/' . $filename;
        }

        Product::create($data);

        return redirect()->route('products-admin')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Categories::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // --- UPDATE (EDIT) ---
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama di folder 'public/storage/products'
            $oldPath = public_path('storage/' . $product->image);
            if ($product->image && file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Upload gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('storage/products');

             if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $filename);
            $data['image'] = 'products/' . $filename;
        }

        $product->update($data);

        return redirect()->route('products-admin')->with('success', 'Product updated successfully.');
    }

    // --- DESTROY (HAPUS) ---
    public function destroy(Product $product)
    {
        $path = public_path('storage/' . $product->image);
        if ($product->image && file_exists($path)) {
            unlink($path);
        }

        $product->delete();
        return redirect()->route('products-admin')->with('success', 'Product deleted successfully.');
    }
}
