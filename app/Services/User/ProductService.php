<?php

namespace App\Services\User;

use App\Models\Product;

class ProductService
{
    /* find all resource */
    public static function findAll()
    {
        return Product::with('category')->latest()->select(['product_id', 'title', 'category_id', 'size', 'price', 'image', 'status'])->paginate(10);
    }

    /* specific reosurces show */
    public static function findById($id)
    {
        return Product::with('category')->find($id);
    }

    /** price filter */
    public static function findFilterPrice($request)
    {
        return Product::select(['product_id', 'title', 'category_id', 'size', 'price', 'image', 'status'])->whereBetween('price', [$request->min_price, $request->max_price])->get();
    }
}
