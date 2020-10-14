<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(){
        $data['posts'] = Blog::select('*')->orderBy('created_at', 'desc')->paginate(2);
        return view('posts', $data);
    }

    public function post(Blog $blog){
        $data['post'] = $blog;
        return view('post', $data);
    }
}
