<div class="recommends">
</div>

<footer class="container footer">


    <div class="site-map row" style="padding: 20px" >
        <div class="col-3" style="text-align: center; padding: 5px">
            <div class="footer-item-menu">
                <a href="/news">Новости</a>
            </div>
            <div class="footer-item-menu">
                <a href="/blogs">Блог</a>
            </div>
            <div class="footer-item-menu">
                <a href="/scores">Онлайн результаты</a>
            </div>
        </div>
        <div class="col-6 row">
            @foreach($topmenu->sortByDesc('order') as $item)
                @if(\TCG\Voyager\Models\MenuItem::where('parent_id', $item->id)->first())
                    <div class="col-6 footer-item-menu" style="text-align: center; padding: 5px;" >
                        <span style="background-color: #28a745; border-radius: 5px;     padding: 3px;">{{$item->title}}</span>
                        <div class="row footer-item-menu">
                            @foreach(\TCG\Voyager\Models\MenuItem::where('parent_id', $item->id)->get() as $child)
                                <a class="col-12" href="{{$child->url}}">{{$child->title}}</a>
                            @endforeach
                        </div>

                    </div>

                @else
                    @if(empty($item->parent_id))
                        <div class="col-4 footer-item-menu" style="text-align: center;padding: 5px;">
                            <a class="" href="{{$item->url}}">{{$item->title}}</a>
                        </div>
                    @endif
                @endif
                @endforeach
        </div>
        <div class="col-3" style="text-align: center; padding: 5px">
            <div class="footer-item-menu">

            </div>
            <div class="footer-item-menu">
                <a href="">Контакты</a>
            </div>
            <div class="footer-item-menu">
                <a href="">Реклама</a>
            </div>
            <div class="footer-item-menu">
                <a href="/policy">Политика конфиденциальности</a>
            </div>
        </div>
    </div>


    <div style="font-size: 13px; padding: 20px; text-align: center">
        <span>
                    © Copyright 2019-{{\Carbon\Carbon::now()->format('Y')}} {{env('APP_SITE')}}
                </span>
        <br>
        Все права на материалы, представленные на сайте, защищены в соответствии с украинским законодательством об
        авторских и смежных правах. При использовании текстовых, аудио и видео материалов сайта гиперссылка на
        {{env('APP_SITE')}} обязательна. Использование фотоматериалов сайта без письменного разрешения редакции
        запрещено. Для печатных изданий указание {{env('APP_SITE')}} обязательно.
    </div>
</footer>
</div>
{{--<script src="/js/jquery-3.5.1.min.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="/js/app.js"></script>
@yield('scripts')
</body>

</html>
