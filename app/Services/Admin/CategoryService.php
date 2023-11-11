<?php

namespace App\Services\Admin;

use App\Models\Category;

class CategoryService
{
    /* find all resource */
    public static function findAll()
    {
        return Category::latest()->get();
    }

    /* store resoruce documents */
    public static function storeDocument($request)
    {
        return array(
            'slug' => $request->category_name,
            'thumbnail' => $request->thumbnail,
            'parent_id' => $request->parent_id,
            'category_name' => $request->category_name,
        );
    }

    /* new store resource docuemnt */
    public static function store($request)
    {
        return Category::create(CategoryService::storeDocument($request));
    }

    /* specific reosurce show */
    public static function findById($id)
    {
        return Category::with('parent')->find($id);
    }

    /* specific resource with field */
    public static function findByField($field, $value)
    {
        return Category::where($field, $value)->first();
    }

    /* specific reosurce update */
    public static function update($id, $request)
    {
        $category = CategoryService::findById($id);
        return $category->update(CategoryService::storeDocument($request));
    }

    /* find by id by Delete */
    public static function findByIdDeleteChecker($id)
    {
        return Category::where('parent_id', $id)->first();   
    }

    /* published or unpublished */
    public static function status($id)
    {
        $category = CategoryService::findById($id);
        if ($category->status == 0) {
            $category->status = 1;
            return $category->save();
        } else {
            $category->status = 0;
            return $category->save();
        }
    }
}
