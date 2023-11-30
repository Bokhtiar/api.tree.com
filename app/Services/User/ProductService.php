<?php

namespace App\Services\User;

use App\Models\Product;

class ProductService
{
    /* find all resource */
    public static function findAll()
    {
        return Product::with('category')->latest()->get(['product_id', 'title', 'category_id', 'size', 'price', 'image', 'status']);
    }

    /* specific reosurces show */
    public static function findById($id)
    {
        return Product::with('category')->find($id);
    }
}
