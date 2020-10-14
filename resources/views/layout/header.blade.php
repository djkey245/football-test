<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{\TCG\Voyager\Models\Setting::where('key','site.title')->first()->value}}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
          rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
          rel="stylesheet">
    @yield('styles')

    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@3.2.0/bulma/bulma.min.css" rel="stylesheet">

</head>
<body>
<div class="container main-bg">
    <div class="row header-top">
        <a href="/" class="col logo float-left">
            {{\TCG\Voyager\Models\Setting::where('key','site.title')->first()->value}}
        </a>
        <div class="col description float-right">
            {{\TCG\Voyager\Models\Setting::where('key','site.description')->first()->value}}
        </div>
    </div>
    <div class="row main-menu">
        @foreach($topmenu as $key=>$item)
            @if(\TCG\Voyager\Models\MenuItem::where('parent_id', $item->id)->first())
                <div class="col item-menu childs">
                    {{$item->title}} <i class="arrow down"></i>
                    <div class="childs-menu">
                        @foreach(\TCG\Voyager\Models\MenuItem::where('parent_id', $item->id)->get() as $child)
                            <a class="child" href="{{$child->url}}">{{$child->title}}</a>
                        @endforeach
                    </div>
                </div>
            @else
                @if(empty($item->parent_id))
                    <div class="col item-menu">
                        <a class="item-menu-link" href="{{$item->url}}">{{$item->title}}</a>
                    </div>
                @endif
            @endif

        @endforeach
    </div>
</div>
<div class="content container">

    <div class="row trends">
        <div class="col-xs-12 col-sm-4 col-xl-3">
            Топ темы за последние трое суток:
        </div>
        <div class="col-xs-12 col-sm-8 col-xl-9">
            <div class="labels">
                @foreach($toplabels as $toplabel)
                    <a class="badge {{$badges[array_rand($badges)]}}" href="/label/{{$toplabel->label->id}}">
                        <span>{{$toplabel->label->name}}</span>
                    </a>
                    {{--                        {{dd($toplabel->label)}}--}}
                @endforeach
            </div>
        </div>
    </div>
</div>
