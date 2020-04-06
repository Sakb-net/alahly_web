@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="video-news section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <!--- latest news -->
                <div class="News">
                    <div class="row">
                        @foreach($data as $keypost=>$val_data)
                        <div class="col-md-4 col-sm-6 wow fadeInUp">
                            <div class="post-block-style clearfix">
                                <div class="post-thumb">
                                    <a href="{{ route('gallery.single',$val_data->link) }}">
                                        @if(!empty($val_data->image))
                                        <img class="img-fluid" src="{{$val_data->image}}" />
                                        @else
                                        <img class="img-fluid" src="{{ asset('images/news-img/sport.jpg') }}" alt="">
                                        @endif
                                        <div class="video-icon"><i class="fa fa-link"></i></div>
                                    </a>
                                </div>
                                <div class="post-content">
                                    <a href="{{ route('gallery.single',$val_data->link) }}">
                                        <h2 class="post-title title-small">{{str_limit($val_data->name, $limit = 50, $end = '...')}}</h2>

                                        <div class="post-meta">
                                            <span class="post-date">{{arabic_date_number($val_data->created_at->format('Y-m-d'),'-')}}</span>
                                        </div>
                                    </a>    
                                </div>
                            </div>
                            <!-- Post Block style end -->
                        </div>
                        @endforeach
                    </div>
                    <!-- pagination -->
                    <div class="row">
                        <div class="styled-pagination col-md-12">
                            <div class="clearfix"></div>
                            <div class="see-more ">
                                {!! $data->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sidebar -->
            @include('site.layouts.sidebar')
        </div>
    </div>
</section>
@endsection
