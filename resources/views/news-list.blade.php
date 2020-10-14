@extends('layout.main')
@section('content')

    <div class="content container wrapper index">
        <div class="row" style="text-align: center;justify-content: center;">
            <div class="col-xs-12 col-sm-10">
{{--                {{dd($news)}}--}}
                @foreach($news as $item)
                    <div class="row item-news" style="border-radius: 10px">
                        <div class="col-3">{{\Carbon\Carbon::parse($item->publish_on_site)->format('d.m H:i')}}</div>
                        <div class="col-7">
                            <a href="/news/{{$item->id}}" style="font-weight: 500">{{$item->title}}</a>
                            <div style="font-size: 12px">{{$item->descr}}</div>
                        </div>
                        <div class="col-2">
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
                    </div>
                @endforeach

                {{ $news->links() }}
            </div>
        </div>
    </div>




@endsection
