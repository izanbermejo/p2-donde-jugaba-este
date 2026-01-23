<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
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

    public function store(Request $request){
        $post = new Post;
        $data = $request->all();
        Post::create($data);
        return $post;
    }
}
