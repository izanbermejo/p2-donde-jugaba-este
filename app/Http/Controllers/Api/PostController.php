<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        $posts = Post::where('title','test')->paginate(2);
        return $posts;
    }

    public function show(Post $post){
        // dd($id);
        // return Post::find($id);
        return $post;
    }

    public function destroy(Post $post){
        $post->delete();
    }

    public function store(StorePostRequest $request){
        $data = $request->validated();
        $post = Post::create($data);
        return $post;
    }
}
