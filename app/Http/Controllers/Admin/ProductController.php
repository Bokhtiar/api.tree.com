<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\HttpResponseTrait;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;

class ProductController extends Controller
{
    use HttpResponseTrait;

    /* Display a listing of the resource. */
    public function index()
    {
        try {
            $data = ProductService::findAll();
            return $this->HttpSuccessResponse("Product list", $data, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:products',
                'price' => 'required',
                "category_id" => "required|exists:categories,category_id",
            ]);

            /* check validator */
            if ($validator->fails()) {
                return $this->HttpErrorResponse($validator->errors(), 422);
            }
            /* store resource */
            $data = ProductService::store($request);
            return $this->HttpSuccessResponse("Product Store Created", $data, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* Display the specified resource. */
    public function show(string $id)
    {
        try {
            $data = ProductService::findById($id);
            return $this->HttpSuccessResponse("Product details", $data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* Update the specified resource in storage */
    public function update(Request $request, string $id)
    {
        try {
            /* isExist product */
            $product = ProductService::findById($id);
            if (!$product) {
                return $this->HttpErrorResponse("The selected Product id is invalid", 404);
            }
            /* form validator */
            $validator = Validator::make($request->all(), [
                'title' => ['required', Rule::unique('products')->ignore($product)],
                'price' => 'required',
                "category_id" => "required|exists:categories,category_id",
            ]);

            /* check validator */
            if ($validator->fails()) {
                return $this->HttpErrorResponse($validator->errors(), 422);
            }

            $data = ProductService::update($id, $request);
            return $this->HttpSuccessResponse("Product Store Updated", $data, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*18 Remove the specified resource from storage. */
    public function destroy(string $id)
    {
        try {
            $product = ProductService::findById($id);
            if (!$product) {
                return $this->HttpErrorResponse('The selected Product id is invalid', 404);
            }
            $product = ProductService::findById($id);
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
            return $this->HttpSuccessResponse('Product Deleted', $product, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* specific resource status update */
    public function status($id)
    {
        try {
            $product = ProductService::findById($id);
            if (!$product) {
                return $this->HttpErrorResponse('The selected Product id is invalid', 404);
            }
            ProductService::status($id);
            return $this->HttpSuccessResponse('Product status updated successfully', $product, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
