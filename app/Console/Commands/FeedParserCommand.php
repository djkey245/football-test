<?php

namespace App\Console\Commands;

use App\Label;
use App\News;
use App\NewsLabel;
use App\Site;
use Carbon\Carbon;
use Illuminate\Console\Command;
use PHPHtmlParser\Dom;
use willvincent\Feeds\Facades\FeedsFacade;

class FeedParserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sites = Site::all();
        foreach ($sites as $site){
            switch ($site->id){
                case 1:
                    $feed = FeedsFacade::make($site->rss, true);

                    $dom = new Dom();
                    $items = $feed->get_items();
                    $items = array_reverse($items);
                    foreach ($items as $key => $item) {

                        if (isset($item->data['child'][""]["link"][0]["data"]) && !empty($item->data['child'][""]["link"][0]["data"])) {
                            $link_string = $item->data['child'][""]["link"][0]["data"];
                            $link = explode('?', $link_string)[0];
                            $labels = [];
                            $title = '';
                            $result = '';
                            $descr = '';
                            $dom->loadFromUrl($link);
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
                            if(!empty($dom->getElementsByClass('tag-string')[0]->getChildren())){
                                $label_count = count($dom->getElementsByClass('tag-string')[0]->getChildren());
                                for($i = 3; $i < $label_count;   ){
                                    if(!empty($dom->getElementsByClass('tag-string')[0]->getChildren()[$i]->getChildren()[0])){
                                        $label = trim($dom->getElementsByClass('tag-string')[0]->getChildren()[$i]->getChildren()[0]->text);
                                        array_push($labels, $label);
                                    }
                                    $i = $i+2;
                                }
                            }
                            if(!empty($item->data['child'][""]["description"][0]["data"])){
                                $descr = $item->data['child'][""]["description"][0]["data"];
                            }
                            $pubDate = null;
                            if(!empty($item->data['child'][""]["pubDate"][0]["data"])){
                                $pubDate = Carbon::parse($item->data['child'][""]["pubDate"][0]["data"]);
                            }


                            if(!empty($title) && !empty($result) && !empty($descr)){
                                $isset = News::where('link', $link)->first();
                                if(empty($isset)){
                                    $news = new News();
                                    $news->title = $title;
                                    $news->descr = $descr;
                                    $news->text = $result;
                                    $news->site_id = $site->id;
                                    $news->link = $link;
                                    $news->active = 1;
                                    $news->publish = 1;
                                    $news->publish_on_site = $pubDate;
                                    $news->save();
                                    if(count($labels) > 0){
                                        foreach ($labels as $label_name){
                                            $label = Label::where('name', $label_name)->first();
                                            if(!empty($label)){
                                                $news_label = new NewsLabel();
                                                $news_label->news_id = $news->id;
                                                $news_label->label_id = $label->id;
                                                $news_label->save();
                                            }
                                            else{
                                                $label = new Label();
                                                $label->name = $label_name;
                                                $label->save();
                                                $news_label = new NewsLabel();
                                                $news_label->news_id = $news->id;
                                                $news_label->label_id = $label->id;
                                                $news_label->save();
                                            }
                                        }
                                    }

                                }
                            }

                        }
                    }
                    break;
            }
        }


    }
}
