@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li>/</li>
            <li><a href="{{ route('gallery.index') }}">مكتبة الصور</a></li>
        </ul>
        <h2>{{$data->name}}</h2>
    </div>
    <!-- /.opacity -->
</div>
<!-- 
    =============================================
        gallery
    ============================================== 
-->
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <ul class="portfolio_items">
                @foreach($sub_albums as $keypost=>$val_data)
                <li class="mix wow fadeInUp">
                    <div class="post_thumb">
                        @if(!empty($val_data->image))
                        <img src="{{$val_data->image}}" alt=""/>
                        @else
                        <img src="{{ asset('images/news-img/sport.jpg')}}" alt=""/>
                        @endif
                        <div class="portfolio-overlay">
                            <div class="overlay-inner">
                                @if(!empty($val_data->image))
                                <a href="{{$val_data->image}}" data-fancybox="gallery">
                                    @else
                                    <a href="{{ asset('images/news-img/sport.jpg')}}" data-fancybox="gallery">
                                        @endif
                                        <i class="fa fa-search-plus"></i>
                                    </a>
                            </div>
                        </div>
                    </div><!--end post thumb-->
                </li>
                @endforeach
            </ul>
        </div>
        <div class="row">
            <!-- share -->
            <div class="share text-center">
                <h3>المشاركة الاجتماعية:</h3>
                <div class="social-sharer">
                    @include('site.layouts.social_icon_green')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
