@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="featured-content">
                    <div class="section-title">
                        <h2>{{$title_one}}</h2>
                    </div>
                    <p class="subtext">{!!$content_one!!}</p>
                    <ul>
                        @foreach ($all_list as $key => $val_list)
                        <li>{{$val_list}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="featured-content-thumb">
                    <img src="{{$image}}" class="img-fluid" alt="About">
                    <!--<img src="images/about.jpg" class="img-fluid" alt="About">-->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="section-title">
                    <h2>{{$title_two}}</h2>
                </div>
                <p>{!!$content_two!!}</p>
            </div>
        </div>
    </div>
</section>
<section class="call-action">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2>لا تتردد في التواصل معانا</h2>
                    <a href="{{ route('contact') }}" class="butn butn-bg"><span>اتصل بنا</span></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
