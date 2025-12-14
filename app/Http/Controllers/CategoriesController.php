<?php

namespace App\Http\Controllers;

use App\Models\Categories as Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
        // 2. Jika ada isinya, batalkan hapus dan kirim pesan error
        return redirect()->route('categories-admin')
            ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk. Hapus atau pindahkan produknya terlebih dahulu.');
    }

    // 3. Jika kosong, baru boleh dihapus
    $category->delete();

    return redirect()->route('categories-admin')
        ->with('success', 'Category deleted successfully.');
    }
}
