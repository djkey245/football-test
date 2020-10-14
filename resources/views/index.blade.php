@extends('layout.main')
@section('content')

    <div class="content container wrapper index">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8">
{{--
                <div class="row">
                    Slider Top News
                    <img src="https://static.ua-football.com/img/upload/19/27ac2f.png" width="100%" heigth="450" alt="">
                </div>
--}}
{{--                <div class="row" style="padding-top: 30px">--}}
                <div class="row" style="">
                    <div class="col-sm-6">
                        <div class="col-12 title-panel">
                            <a href="/news" style="color: white">Все новости</a>
                        </div>
                        @foreach($news as $item)
                            <a class="row item-news" href="/news/{{$item->id}}">
                                <div
                                    class="col-3">{{\Carbon\Carbon::parse($item->publish_on_site)->format('d.m H:i')}}</div>
                                <div class="col-9">{{$item->title}}
                                    @if($item->site->id == 1)
                                        <span class="badge {{$badges[2]}}">{{$item->site->name}}</span>
                                    @elseif($item->site->id == 2)
                                        <span class="badge {{$badges[4]}}">{{$item->site->name}}</span>
                                    @elseif($item->site->id == 3)
                                        <span class="badge {{$badges[5]}}">{{$item->site->name}}</span>
                                    @elseif($item->site->id == 4)
                                        <span class="badge {{$badges[7]}}">{{$item->site->name}}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="col-sm-6">
                        <div class="col-12 title-panel">
                            <a href="/blogs" style="color: white">Все статьи</a>
                        </div>
                        @foreach($posts as $post )
                            <div class="row " style="padding: 5px">
                                <div class="col-12 item-blogs">
                                    <img class="img-fluid " src="/storage/{{$post->image}}" style=" border-radius: 5px"
                                         alt="{{$post->title}}">
                                    <div style="padding: 10px" class="row">
                                        <span class="col-12"
                                              style="font-size: 13px; font-weight: 500">{{\Carbon\Carbon::parse($post->publish_date)->format('d.m.Y H:i')}}</span>
                                        <a class="col-12" href="/blog/{{$post->id}}"
                                           style="color: #333333; font-weight: 600">{{$post->title}}</a>
                                        <div class="col-12" style="font-size: 13px">{{$post->description}}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="col-12 title-panel" style="margin: 0">
                    <span style="color: white">Футбол онлайн</span>
                </div>

                <div class="col-12" style="color: #333333;">
{{--                    {{dd($live_results)}}--}}

                    @foreach($live_results as $live_result)
                        @if($live_result->tournament_weight <= 200)
                            <div class="row">
                                <div
                                    class="col-12 " style="text-align: center; margin: 10px 0 7px 0">
                                <span
                                    class="col-8 category-scores">{{$live_result->hide_category ? '' : $live_result->category_name.'. '}}{{$live_result->tournament_name}}
                                </span>

                                </div>
                                <div class="col-12">
                                    @foreach($live_result->matches as $match)
                                        <div class="row item-scores" style="font-size: 12px; font-weight: 500">
                                            <div class="col-4"
                                                 style="text-align: right;align-self: center; padding: 10px;">
                                                <span>{{$match->team_home->name}}</span>
                                            </div>
                                            <div class="col-1"
                                                 style="padding: 0;text-align: center; align-self: center;">
                                                <img src="{{$match->team_home->logo_small}}" alt=""
                                                     style="max-height: 16px; max-width: 20px; min-width: 16px">
                                            </div>
                                            <div class="col-2"
                                                 style="text-align: center;align-self: center; padding: 0; font-weight: 700;">
                                                @if($match->status == "Не начался")
                                                    <span
                                                        style="color: green">{{\Carbon\Carbon::parse($match->date_of_match)->timezone('Europe/Kiev')->format('m.d H:i')}}</span>
                                                @elseif($match->status == "Закончен")
                                                    {{$match->scores->normaltime}}
                                                @elseif(!empty($match->scores))
                                                    <span style="color: red">{{$match->scores->current}}</span>
                                                @else
                                                    -:-
                                                @endif
                                            </div>
                                            <div class="col-1"
                                                 style="padding: 0;text-align: center; align-self: center;">
                                                <img src="{{$match->team_away->logo_small}}" alt=""
                                                     style="max-height: 16px; max-width: 20px; min-width: 16px">
                                            </div>

                                            <div class="col-4"
                                                 style="text-align: left;align-self: center;padding: 10px;">
                                            <span>
                                            {{$match->team_away->name}}
                                            </span>
                                            </div>
                                        </div>


                                    @endforeach
                                </div>
                            </div>
                        @endif

                    @endforeach
                </div>

            </div>
        </div>
    </div>




@endsection
