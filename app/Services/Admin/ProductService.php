<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Traits\ImageUpload;

class ProductService
{
    /* find all resource */
    public static function findAll()
    {
        return Product::latest()->get(['product_id', 'title', 'inc_id', 'price', 'image', 'status']);
    }

    /* store resources documents */
    public static function storeDocument($request, $image = null)
    {
        /* image store and update*/
        if ($request->hasFile('image')) {
            $path = 'images/product/';
            $db_field_name = 'image';
            $image =  ImageUpload::Image($request, $path, $db_field_name);
        } else {
            $image = $image;
        }

        return array(
            'slug' => $request->title,
            'title' => $request->title,
            'image' => $image,
            'inc_id' => $request->inc_id,
            'ratting' => $request->ratting,
            'parent_id' => $request->parent_id,
            'category_id' => $request->category_id,
            'product_body' => $request->body,
            'plant_body' => $request->plant_body,
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
        return Product::find($id);
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
