@foreach($products as $keyprod=>$data)
<div class="col-md-4 col-sm-6 wow fadeInUp">
    <div class="shop_thumb">
        <div class="thumb">
            <a href="{{ route('categories.category.products.single',[$data['cat_link'],$data['link']]) }}">
                <img src="{{$data['image']}}" alt="">
            </a>
        </div>
        <div class="text">
            <h6><a href="{{ route('categories.category.single',$data['cat_link']) }}">{{$data['cat_name']}}</a></h6>
            <h5><a href="{{ route('categories.category.products.single',[$data['cat_link'],$data['link']]) }}">{{$data['name']}}</a></h5>
            <span class="price_tag">{{$data['total_price']}}ريال</span>
            @include('site.products.add_cart')
        </div>
    </div>
</div>
@endforeach