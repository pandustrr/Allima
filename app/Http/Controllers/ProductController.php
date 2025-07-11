<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showOrderForm(Product $product)
    {
        return view('beli', compact('product'));
    }
}
