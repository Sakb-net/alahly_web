<div class="shop_icons">
    <!--<a class="butn butn-bg">-->
        <!--<span class="add_cart_product" data-link="{{$data['link']}}" data-name=""><i class="fa fa-shopping-cart"></i> أضف للسلة</span>-->
    <a class="butn butn-bg" href="{{ route('categories.category.products.single',[$data['cat_link'],$data['link']]) }}">
        <span><i class="fa fa-shopping-cart"></i> عرض التفاصيل</span>
    </a>
</div>