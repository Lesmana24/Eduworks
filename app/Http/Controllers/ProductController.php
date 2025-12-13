<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

    // 1. Filter Pencarian
    if ($request->has('search') && $request->search != null) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // 2. Filter Kategori (Array)
    if ($request->has('category') && is_array($request->category)) {
        $query->whereIn('category_id', $request->category);
    }

    // 3. Filter Harga
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // 4. Sorting (Logika yang sebelumnya sudah ada)
    if ($request->sort == 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort == 'price_desc') {
        $query->orderBy('price', 'desc');
    } elseif ($request->sort == 'newest') {
        $query->orderBy('created_at', 'desc');
    } else {
        $query->latest();
    }


        $products = $query->paginate(4)->withQueryString();
        $categories = Categories::all();
        return view('dashboard.products.index' , compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
