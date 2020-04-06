@if(count($product_cart)>0)
    @foreach($product_cart as $keycart=>$val_cart)
      <li>
          <a href="{{ route('categories.category.products.single',[$val_cart['cat_link'],$val_cart['link']]) }}" class="photo">
              <img src="{{ $val_cart['image']}}" class="cart-thumb" alt="" />
          </a>
          <h6><a href="{{ route('categories.category.products.single',[$val_cart['cat_link'],$val_cart['link']]) }}">{{ $val_cart['name']}}</a></h6>
          <p>{{ $val_cart['quantity']}}x <span class="price">{{ $val_cart['total_price']}} ريال</span></p>
      </li>
     @endforeach
 @else    
    <li>@include('site.products.message_empty')</li>
@endif
<li class="total">
    @foreach($cart_fees as $key_fees=>$val_fees)
        <span class="pull-left"><strong>{{$val_fees['name']}}</strong>:{{$val_fees['total_price']}} ريال</span>
    @php $total_price_cart +=$val_fees['total_price'] @endphp
    @endforeach
    <span class="pull-left"><strong>الإجمالي</strong>:{{$total_price_cart}} ريال</span>
    <a href="{{ route('products.cart') }}" class="btn btn-default btn-cart">الذهاب للسلة</a>
</li>
