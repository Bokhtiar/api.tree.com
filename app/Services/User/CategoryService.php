<?php

namespace App\Services\User;

use App\Models\Category;

class CategoryService
{
    /* find all resource */
    public static function findAll()
    { 
        return Category::latest()->with('childs')->get();
    }
}
