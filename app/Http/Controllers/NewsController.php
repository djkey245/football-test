<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{


    public function index(){

        $data['news'] = News::select('*')->orderBy('created_at', 'desc')->with('site')->paginate(10);

        return view('news-list', $data);
    }

    public function news(News $news){

        $data['allnews'] = News::select('*')->orderBy('publish_on_site', 'desc')->with('site')->take(30)->get();

        $data['news'] = $news->load('site', 'labels');

        return view('news', $data);
    }
}
