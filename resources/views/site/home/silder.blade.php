<div class="slider-area">
    <div class="slider-active owl-carousel owl-dot-style">
        <div class="slider-height bg-img" style="background-image:url({{ asset('images/slider/1.jpg')}});">
            @if(!empty($match_next))
            <div class="slider-content slider-animated">
                <h3 class="animated">المباراة القادمة</h3>
                <h1 class="animated">
                    <ul class="match-vs">
                        <li><img src="{{$match_next['first_image']}}" alt="{{$match_next['first_team']}}"><span>{{$match_next['first_team']}}</span></li>
                        <li class="vs">
                            <h4 class="yellow">- VS -</h4>
                        </li>
                        <li><img src="{{$match_next['second_image']}}" alt="{{$match_next['second_team']}}"><span>{{$match_next['second_team']}}</span></li>
                    </ul>
                </h1>
                <p class="animated">{{$match_next['date']}} {{$match_next['time']}}</p>
                <a href="{{$match_next['link_ticket']}}" class="butn butn-bord"><span>احجز تذكرتك الآن</span></a>
            </div>
            @else
             <div class="slider-content slider-animated">
                <h3 class="animated">يوجد لدينا</h3>
                <h1 class="animated">أفضل<span class="yellow"> المنتجات </span>الرياضية</h1>
                <div class="gap"></div>
                <a href="{{ route('categories.index') }}" class="butn butn-bord"><span>تسوق الآن</span></a>
            </div>
            @endif
        </div>
        <div class="slider-height bg-img" style="background-image:url({{ asset('images/slider/2.jpg')}});">
            <div class="slider-content slider-animated">
                <h3 class="animated">يوجد لدينا</h3>
                <h1 class="animated">أفضل<span class="yellow"> المنتجات </span>الرياضية</h1>
                <div class="gap"></div>
                <a href="{{ route('categories.index') }}" class="butn butn-bord"><span>تسوق الآن</span></a>
            </div>
        </div>
    </div>
</div>