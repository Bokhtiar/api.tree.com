<?php

namespace App\Services\User;

use App\Models\Product;
use App\Models\Category;

class CategoryService
{
    /* find all resource */
    public static function findAll()
    { 
        return Category::latest()->with('childs')->get();
    }

    /** category has assing product */
    public static function CategoryHasAssign($id)
    {
        return Product::where('status', 1)->where('category_id', $id)->select(['product_id', 'title', 'category_id', 'size', 'price', 'image', 'status'])->paginate(10);
    }
}
