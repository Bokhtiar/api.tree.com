<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\CategoryService;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use HttpResponseTrait;

    /** reosurce list */
    public function index() 
    {
        $data = CategoryService::findAll();
        return $this->HttpSuccessResponse("Category list", $data, 200);
    }
}
