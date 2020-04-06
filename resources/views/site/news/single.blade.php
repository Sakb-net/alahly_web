@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li>/</li>
            <li><a href="{{ route('news.index') }}">أخبار النادي</a></li>
        </ul>
        <h2>{{$data->name}}</h2>
    </div>
</div>
<section class="video-news section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="news-boxed-img">
                    <div id="post-meta">
                        <div id="meta-content">
                            <span><i class="fa fa-calendar"></i> {!!arabic_date_number($data->created_at->format('Y-m-d'),'-')!!}</span>
                            <span><i class="fa fa-clock-o"></i> {!!Time_Elapsed_String($data->created_at->format('Y-m-d'),'ar')!!}</span>
                            <span><i class="fa fa-eye"></i> {{$data->view_count}} </span>
                        </div>
                    </div>
                    @if(!empty($data->image))
                    <img src="{{$data->image}}" class="img-responsive" alt=""/>
                    @else
                    <img src="{{ asset('images/news-img/sport.jpg')}}" class="img-responsive" alt=""/>
                    @endif
                </div>
                <section class="news-sections">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-section">
                                <div id="page-content">
                                    <!-- end social share -->
                                    {!!$data->description!!}
                                    <!-- social share -->
                                    <div class="share">
                                        <div class="section-title">
                                            <h2>المشاركة الاجتماعية</h2>
                                        </div>
                                        <div class="social-sharer">
                                            @include('site.layouts.social_icon_green')
                                        </div>
                                    </div>
                                </div>
                            @include('site.layouts.comment')
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- sidebar -->
        @include('site.layouts.sidebar')
        </div>
    </div>
</section>
@endsection
@section('after_head')
@stop  
@section('after_foot')
<script type="text/javascript" src="{{ asset('js/site/comment.js') }}"></script>
@stop  
