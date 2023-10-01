<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Traits\HttpResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\ProductService;

class ProductController extends Controller
{
    use HttpResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'price' => 'required',
                'inc' => 'required',
                "category_id" => "required|exists:categories,category_id",
                'ratting' => 'required',
            ]);

            // 'email' => 'required|email|unique:users,email,'.$user->id,
            /* check validator */
            if ($validator->fails()) {
                return $this->HttpErrorResponse($validator->errors(), 422);
            }

            /* check exist name */
            $existTitle = Product::where('title', $request->title)->where('inc', $request->inc)->first();
            if ($existTitle) {
                return $this->HttpErrorResponse("Product title already exist", 409);
            }

            $data = ProductService::store($request);
            return $this->HttpSuccessResponse("Product Store Created", $data, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
