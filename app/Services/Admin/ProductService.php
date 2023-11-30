<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Traits\ImageUpload;

class ProductService
{
    /* find all resource */
    public static function findAll()
    {
        return Product::with('category')->latest()->get(['product_id', 'title', 'category_id', 'size', 'price', 'image', 'status']);
    }

    /* store resources documents */
    public static function storeDocument($request, $image = null)
    {
        /* image store and update*/
        if ($request->image) {
            $path = 'images/product/';
            $db_field_name = 'image';
            $image =  ImageUpload::Image($request, $path, $db_field_name);
        }
        return array(
            'image' => $image,
            'body' => $request->body,
            'size' => $request->size,
            'slug' => $request->title,
            'price' => $request->price,
            'title' => $request->title,
            'ratting' => $request->ratting,
            'product_body' => $request->body,
            'parent_id' => $request->parent_id,
            'plant_body' => $request->plant_body,
            'category_id' => $request->category_id,
        );
    }

    /* new store resource documents */
    public static function store($request)
    {
        return Product::create(ProductService::storeDocument($request));
    }

    /* specific reosurces show */
    public static function findById($id)
    {
        return Product::with('category')->find($id);
    }

    public static function findByIdDeleteChecker($id)
    {
        return Product::where('parent_id', $id)->first();
    }

    /* specific reosurces update */
    public static function update($id, $request)
    {
        $product = ProductService::findById($id);
        return $product->update(ProductService::storeDocument($request, $product->image));
    }

    /* published or unpublished */
    public static function status($id)
    {
        $product = ProductService::findById($id);
        if ($product->status == 0) {
            $product->status = 1;
            return $product->save();
        } else {
            $product->status = 0;
            return $product->save();
        }
    }
}
