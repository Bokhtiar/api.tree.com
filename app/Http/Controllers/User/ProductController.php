<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\ProductService;
use App\Traits\HttpResponseTrait;

class ProductController extends Controller
{
    use HttpResponseTrait;
    
    /** resource list */
    public function index()
    {
        try {
            $data = ProductService::findAll();
            return $this->HttpSuccessResponse("Product list", $data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /** resource show */
    public function show($id)
    {
        try {
            $data = ProductService::findById($id);
            return $this->HttpSuccessResponse("Product show", $data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
