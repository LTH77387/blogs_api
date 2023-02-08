<?php
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostDetialController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware'=>'auth:api'],function(){
    Route::get('profile',[ProfileController::class,'profile']);
    Route::get('profile-posts',[ProfileController::class,'posts']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('categories',[CategoryController::class,'index']);
    Route::post('category/create',[CategoryController::class,'create']);
    // posts
    Route::get('/posts',[PostController::class,'index']);
    Route::post('/post/create',[PostController::class,'create']);
    Route::get('/post/{id}',[PostController::class,'show']);

});

