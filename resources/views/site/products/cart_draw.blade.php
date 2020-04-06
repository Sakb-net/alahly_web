@if(count($product_cart)>0)
    @foreach($product_cart as $keycart=>$val_cart)
    <tr>
        <td class="pro-thumbnail">
            <a href="{{ route('categories.category.products.single',[$val_cart['cat_link'],$val_cart['link']]) }}"><img src="{{ $val_cart['image']}}" alt="Product"></a>
        </td>
        <td class="pro-title"><a href="{{ route('categories.category.products.single',[$val_cart['cat_link'],$val_cart['link']]) }}">{{ $val_cart['name']}}</a></td>
        <td class="pro-price"><span>{{ $val_cart['total_price']}} ريال</span></td>
        <td class="pro-quantity">
            <div class="pro-qty">
                <input type="text" min="1" class="changnum_cartProduct" value="{{ $val_cart['quantity']}}" data-link="{{$val_cart['link']}}" data-name="{{$val_cart['name']}}">
            </div>
        </td>
        <td class="pro-subtotal"><span>{!! $val_cart['total_price'] * $val_cart['quantity']!!} ريال</span></td>
        <td class="pro-remove"><a class="remove_cartProduct" data-link="{{$val_cart['link']}}" data-name="{{$val_cart['name']}}"><i class="fa fa-trash-o"></i></a></td>
    </tr>
    @endforeach
@else    
    @include('site.products.body_empty')
@endif