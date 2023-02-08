<?php

namespace App\Http\Controllers\Api;

use auth;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
   public function profile(){
    $user=auth()->guard()->user();
    // return $user;
    // $userResource = new ProfileResource($user);
    // return $userResource;
    return ResponseHelper::success(new ProfileResource($user));
   }
   public function posts(Request $request){
    $query = Post::with('category','image','user')->orderByDesc('created_at')->where('user_id',auth()->user()->id);
    if($request->category_id){
        $category_id = $request->category_id;
        $query->where('category_id',$category_id);
    }
    if($request->search){
        $query->where(function($search) use ($request){
            $search->where('title','like','%' . $request->search . '%')
                   ->orWhere('description','like' .$request->search. '%');
        });
    }
    $posts = $query->paginate(10);
    return PostResource::collection($posts);
}
}
