<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index(Request $request){
        $query = Post::with('category','image','user')->orderByDesc('created_at');
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
public function create(Request $request){
$request->validate([
    'title'=>'required|string',
    'description'=>'required|string',
    'category_id'=>'required'
]);
DB::beginTransaction();
try {
    $file_name = null;
    if($request->hasFile('image')){
        $file = $request->file('image');
        $file_name = uniqid() . '_' . date("Y-m-d-H-i-s") . '.' . $file->getClientOriginalExtension();

        Storage::put('/media/' . $file_name, file_get_contents($file));
    }

    $postData = [
        'title'=>$request->title,
        'description'=>$request->description,
        'user_id'=>auth()->user()->id,
        'category_id'=>$request->category_id
      ];

  $post= Post::create($postData);
      Media::create([
          'file_name' => $file_name,
          'file_type' => 'image',
          'model_id' => $post->id,
          'model_type' => Post::class,
      ]);
      DB::commit();
      return ResponseHelper::success([],'Created Successfully!');
}catch(exception $err){
    DB::rollback();
    return ResponseHelper::fail($err);
}
}
public function show ($id){
  $post =Post::with('category','image','user')->where('id',$id)->firstOrFail();
  return ResponseHelper::success(new PostDetailResource($post));
}
}
