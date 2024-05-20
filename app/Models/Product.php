<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'quantity', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Méthode pour récupérer les produits similaires
    public function similarProducts()
    {
        return Product::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->limit(5)
            ->get();
    }
}

