@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="border_box">
                    <div class="widget">
                        <h3>الأقسام:</h3>
                            <ul class="list-group">
                            <li class="list-group-item">
                                <a class="get_categoriesProduct @if($active_cat_link=='all') active_cat @endif" data-link="all" >كل المنتجات</a>
                            </li>
                            @foreach($categories as $keycat=>$val_cat)
                            @if(count($val_cat['subcategories'])>0)
                                <li class="list-group-item">
                                <a class="accordion-toggle" data-toggle="collapse" href="#collapse{{$keycat}}">{{$val_cat['name']}}</a>
                                <div id="collapse{{$keycat}}" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <ul class="list-group">
                                            @foreach($val_cat['subcategories'] as $keysub=>$val_sub)
                                            <li class="list-group-item">
                                                <a class="get_categoriesProduct @if($active_cat_link==$val_sub['link']) active_cat @endif" data-link="{{$val_sub['link']}}">{{$val_sub['name']}}<span class="badge">({{$val_sub['products_count']}})</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            @else
                              <li class="list-group-item">
                                <a class="get_categoriesProduct @if($active_cat_link==$val_cat['link']) active_cat @endif" data-link="{{$val_cat['link']}}">{{$val_cat['name']}}<span class="badge">({{$val_cat['products_count']}})</span></a>
                               </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="products col-md-9">
                <div class="shop-toolbar">
                    <div class="col-md-6 product-showing">
                    <!--<div class="col-md-6 product-showing count_product_cat">-->
                        <!--<p>{{$count_product}}</p>-->
                        <!--<p>عرض 9 من 27 </p>-->
                    </div>
                    <div class="col-md-6 product-short">
                        <p>ترتيب: </p>
                        <input type="hidden" value="{{$active_cat_link}}" id="input_cat_sort">
                        <select class="form-control sort_cat_Product" id="sort_cat_Product">
<!--                            <option value="rate">الأعلي تقييما</option>-->
                            <option value="new">الأحدث</option>
                            <option value="price_asc">السعر من الأقل للأعلي</option>
                            <option value="price_desc">السعر من الأعلي للاقل</option>
                        </select>
                    </div>
                </div>
                <!-- =======products ==========-->
                @include('site.products.products')
            </div>
        </div>
        <div class="row">
            <!--pagination -->
            <!--@include('site.products.pagination')-->
        </div>
    </div>
</section>
@endsection
@section('after_head')
@stop  
@section('after_foot')
<script type="text/javascript" src="{{ asset('js/site/product.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/site/cart.js') }}"></script>
@stop  
