@extends('site.layouts.app')
@section('content')
<div class="myinner-banner" style="background: url({{ asset('images/bg/inner-banner2.jpg')}}) no-repeat center;">
    <div class="opacity">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li>/</li>
            <li><a href="{{ route('categories.category.single',$catgeory->link) }}">{{$catgeory->name}}</a></li>
        </ul>
        <h2>{{$data['name']}}</h2>
    </div>
</div>
<section class="section-padding wow fadeInUp product-area-sec">
    <div class="container">
        <div class="row">
            <!-- product imgs -->
            @include('site.products.single_slider')
            <!-- product details -->
            <div class="col-md-7">
                <div class="product-details-sec">
                    <h2>{{$data['name']}}</h2>
                    <div class="product-details-price">
                        <span class="product_price">{{$data['total_price']}} ريال</span>
                        @if($data['total_price']<$data['price'])
                        <span class="old product_oldprice">{{$data['price']}} ريال</span>
                        @endif
                    </div>
                    <div class="pro-details-rating-wrap">
                        <div class="pro-details-rating">
                            @for ($star = 1; $star <= 5; $star++)
                            @if($data['star_rate'] >=$star)
                            <i class="fa fa-star"></i>
                            @else
                            <i class="fa fa-star-o"></i>
                            @endif
                            @endfor
                        </div>
                        <span>{{$data['rate']}} تقييمات</span>
                    </div>
                    <div class="product-details-content">
                        <p>{!!$data['description']!!}</p>
                    </div>
                    @include('site.products.single_form')
                    <div class="col-md-12">
                        <div class="share">
                            <h3>المشاركة الإجتماعية:</h3>
                            <div class="social-sharer">
                                @include('site.layouts.social_icon_green')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- description & reviews -->
        <div class="description-review-area ">
            <div class="description-review-wrapper">
                <div class="description-review-topbar">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link" data-toggle="tab" href="#des-details2" role="tab">الوصف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#des-details1" role="tab">معلومات إضافية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#des-details3" role="tab">التقييمات</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content description-review-bottom">
                    <div id="des-details2" class="tab-pane active">
                        <div class="product-description-wrapper">
                            <p>{!!$data['description']!!}</p>
                        </div>
                    </div>
                    <div id="des-details1" class="tab-pane ">
                        <div class="product-anotherinfo-wrapper">
                            <ul>
                                @if(!empty($data['city_made']))
                                <li><span>بلد الصنع</span> {!!$data['city_made']!!}</li>
                                @endif
                                @if(count($data['color'])>0)
                                <li><span>الالوان</span>
                                    @foreach($data['color'] as $key_col=>$val_col)
                                    <span class="prod-weight"> {!!$val_col['name']!!}</span>
                                    @endforeach
                                </li>
                                @endif
                                @if(count($data['weight'])>0)
                                <li><span>المقاسات</span>
                                    @foreach($data['weight'] as $key_wig=>$val_wig)
                                    <span class="prod-weight"> {!!$val_wig['name']!!} </span>
                                    @endforeach
                                </li>
                                @endif
                                @if(!empty($data['valid_number_prod']))
                                <li><span>العدد المتاح</span>{!!$data['valid_number_prod']!!} قطعة</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div id="des-details3" class="tab-pane">
                        <div class="row">
                            @include('site.products.comments')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('after_head')
@stop  
@section('after_foot')
<script type="text/javascript" src="{{ asset('js/site/product.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/site/comment.js') }}"></script>
@stop  
