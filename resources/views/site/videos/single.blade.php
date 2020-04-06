@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li>/</li>
            <li><a href="{{ route('videos.index') }}">الفديوهات</a></li>
        </ul>
        <h2>{{$data->name}}</h2>
    </div>
    <!-- /.opacity -->
</div>
<section class="video-news section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @if($upload==1)
                <iframe width="100%" height="500" src="{{$data->video}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>  
                @else
                <object id="myVideo" width="100%" height="500"  type="application/x-shockwave-flash" @if(isset($data->video))  data="{{$data->video}}" @else style="display:none;" @endif>
                        <param name="src" id="myVideo" @if(isset($data->video)) value="{{$data->video}}" @else style="display:none;" @endif />
                </object>
                @endif

                <section class="news-sections">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-section">
                                <div id="page-content">
                                    <!-- end social share -->
                                    {!!$data->content!!}
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
