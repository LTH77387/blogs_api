<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
   public function index(){
       $categories = Category::orderBy('category_name')->get();
       return CategoryResource::collection($categories);
   }
   public function create(Request $request){
        $request->validate([
            'category_name'=>'required',
        ]);
        Category::create([
            'category_name'=>$request->category_name,
        ]);
        return ResponseHelper::success([],'Created Successfully!');
   }
}
