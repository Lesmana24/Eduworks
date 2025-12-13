<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::paginate(4);
        return view('dashboard.home', compact('products'));
    }

    public function cart()
    {
        return view('dashboard.cart');
    }
}
