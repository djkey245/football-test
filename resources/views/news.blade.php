@extends('layout.main')
@section('content')

    <div class="content container wrapper">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <div class="col-12" style="text-align: center; font-size: 18px; font-weight: 500; margin-bottom: 10px">{{$news->title}}</div>
                <div class="row">
                    <div class=" col" style="text-align: right; font-size: 13px; font-weight: 600; align-self: center">
                        {{\Carbon\Carbon::parse($news->publish_on_site)->format('d.m.Y H:m')}}
                    </div>
                    <div class=" col">
                        <a href="{{$news->link}}" target="_blank" style="color: #dc3545;">Новость взята из сайта {{$news->site->name}}</a>
                    </div>

                </div>
                <div style="padding: 20px">
                    {!! $news->text !!}

                </div>

                <div  style="padding: 0 20px">
                    <div style="display: inline-block;" class="labels">
                        <div style="display: inline-block; font-weight: 500">Теги:</div>

                    @foreach($news->labels as $label)
                            <a class="badge {{$badges[array_rand($badges)]}}" href="/label/{{$label->id}}">
                                <span>{{$label->name}}</span>
                            </a>
                            {{--                        {{dd($toplabel->label)}}--}}
                        @endforeach
                    </div>

                </div>

            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="col-12 title-panel">
                    <a href="/news" style="color: white">Все новости</a>
                </div>
                @foreach($allnews as $item)
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

            {{--            {{dd($news)}}--}}
        </div>
    </div>




@endsection
