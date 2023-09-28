<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\HttpResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\Admin\CategoryService;

class CategoryController extends Controller
{
    use HttpResponseTrait;
    
    /* Display a listing of the resource. */
    public function index()
    {
        try {
            $data = Category::whereNull('parent_id')->with('childs')->get();
            return $this->HttpSuccessResponse('Category items', $data, 200);    
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /* Store a newly created resource in storage. */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
            'category_name' => 'required|string',
        ]);

        /* check validator */
        if ($validator->fails()) {
            return $this->HttpErrorResponse($validator->errors(), 422);
        }

        /* exist resource */
        $existCategory = CategoryService::findByField('category_name', $request->category_name); 
        if ($existCategory) {
            return $this->HttpErrorResponse('Category Name Already Exist', 422);
        }

        $data = CategoryService::store($request);

        return $this->HttpSuccessResponse("Category Store Created", $data, 201);
    }

    /* Display the specified resource. */
    public function show(string $id)
    {
        try {
            $data = CategoryService::findById($id);
            return $this->HttpSuccessResponse('Category Details', $data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* Update the specified resource in storage. */
    public function update(Request $request, string $id)
    {
        try {
            $data = CategoryService::update($id, $request);
            return $this->HttpSuccessResponse("Category Updated", $data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $id)
    {
        try { 
            $data = CategoryService::findByIdDeleteChecker($id);
            if ($data) {
                return $this->HttpErrorResponse('Already Exist subCategory', 422);
            }else{
                CategoryService::findById($id)->delete();
            }
            return $this->HttpSuccessResponse('Category Deleted', $data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
