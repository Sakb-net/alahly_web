<section class="section-padding wow fadeInUp white-bg">
    <div class="container">
        <div class="row">
            <h3 class="block-title">
                <span>أحدث المنتجات</span>
                <a class="read-more" href="{{route('categories.index')}}">المزيد ...</a>
            </h3>
            <div class="latest-slider owl-carousel">
                @foreach($products as $keyprod=>$data)
                <!-- product item -->
                <div class="item">
                    <div class="shop_thumb">
                        <div class="thumb">
                            <a href="{{ route('categories.category.products.single',[$data['cat_link'],$data['link']]) }}">
                                <img src="{{$data['image']}}" alt="">
                            </a>
                        </div>
                        <div class="text">
                            <h6><a href="{{ route('categories.category.single',$data['cat_link']) }}">{{$data['cat_name']}}</a></h6>
                            <h5><a href="{{ route('categories.category.products.single',[$data['cat_link'],$data['link']]) }}">{{$data['name']}}</a></h5>
                            <span class="price_tag">{{$data['total_price']}} ريال</span>
                            @include('site.products.add_cart')
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>