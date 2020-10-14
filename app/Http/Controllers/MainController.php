<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Label;
use App\LiveResult;
use App\News;
use App\NewsLabel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PHPHtmlParser\Dom;
use TCG\Voyager\Models\MenuItem;
use willvincent\Feeds\Facades\FeedsFacade;
use willvincent\Feeds\FeedsFactory;

class MainController extends Controller
{

    public function index()
    {

//        dd(json_decode());


        $live_result = LiveResult::whereDate('created_at',Carbon::now())->first();
        if(!empty($live_result)){
            $data['live_results'] = json_decode($live_result->json);
        }
        else{
            $live_result = LiveResult::select('*')->orderBy('created_at', 'desc')->first();
            $data['live_results'] = json_decode($live_result->json);
        }
        $data['news'] = News::select('*')->orderBy('publish_on_site', 'desc')->with('site')->take(30)->get();
        $data['posts'] = Blog::select('*')->orderBy('publish_date', 'desc')->take(5)->get();
        return view('index', $data);
    }

    public function policy(){


        return view('policy');
    }

    public function test()
    {

        //https://www.ua-football.com/rss/all.xml
        //https://ua.tribuna.com/rss/topnews.xml
        //https://sportarena.com/feed/
        //https://terrikon.com/rss

        $feed = FeedsFacade::make('https://terrikon.com/rss', true);

        $dom = new Dom();
        $items = $feed->get_items();
        $items = array_reverse($items);
        foreach ($items as $key => $item) {

            if (isset($item->data['child'][""]["link"][0]["data"]) && !empty($item->data['child'][""]["link"][0]["data"])) {
//                dd();
                $link_string = $item->data['child'][""]["link"][0]["data"];
                $link = explode('?', $link_string)[0];
                $dom->loadFromUrl($link);
                $labels = [];
                $title = '';
                $result = '';
                $descr = '';
//                dd($link);
                if (isset($dom->getElementsByClass('news-head')[0]->getChildren()[1]->getChildren()[0]) &&
                    !empty($dom->getElementsByClass('news-head')[0]->getChildren()[1]->getChildren()[0])) {
                    $title = $dom->getElementsByClass('news-head')[0]->getChildren()[1]->getChildren()[0]->text;
                }
                if (isset($dom->getElementsByClass('posttext')[0]) && !empty($dom->getElementsByClass('posttext')[0])) {
                    $body = $dom->getElementsByClass('posttext')[0];
                    $count = count($body->getChildren());
                    $body = $body->outerHtml;

                    $result = str_replace('<a ', '<b ', $body);
                    $body = $result;
                    $result = str_replace('</a>', '</b>', $body);
                }
                if (!empty($dom->getElementsByClass('tag-string')[0]->getChildren())) {
                    $label_count = count($dom->getElementsByClass('tag-string')[0]->getChildren());
                    for ($i = 3; $i < $label_count;) {
                        if (!empty($dom->getElementsByClass('tag-string')[0]->getChildren()[$i]->getChildren()[0])) {
                            $label = trim($dom->getElementsByClass('tag-string')[0]->getChildren()[$i]->getChildren()[0]->text);
                            array_push($labels, $label);
                        }
                        $i = $i + 2;
                    }
                }
                if(!empty($item->data['child'][""]["description"][0]["data"])){
                    $descr = $item->data['child'][""]["description"][0]["data"];
                }
                if(!empty($item->data['child'][""]["pubDate"][0]["data"])){
                    $pubDate = Carbon::parse($item->data['child'][""]["pubDate"][0]["data"]);
                }

                dd($labels);

                if (!empty($title) && !empty($result) && !empty($descr)) {
                    $news = new News();
                    $news->title = $title;
                    $news->descr = $descr;
                    $news->text = $result;
                    $news->site_id = 1;
                    $news->link = $link;
                    $news->save();
                    if (count($labels) > 0) {

                    }
                }
            }
        }
        return view('test');
    }
}
