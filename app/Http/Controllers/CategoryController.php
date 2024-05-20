<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Récupère toutes les catégories avec leurs images
        $categories = Category::all();
        return response()->json($categories);
    }
}
