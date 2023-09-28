<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;

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