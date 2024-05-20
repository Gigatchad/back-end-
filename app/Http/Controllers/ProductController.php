<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Récupérer tous les produits
        $products = Product::all();
        return response()->json($products);
    }
    
}
