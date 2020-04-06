@foreach($carts as $key_cart=>$val_cart)
<tr>
    <td>{{$val_cart['link']}}</td>
    <td>{{$val_cart['match_name']}}</td>
    <td>
        <ul dir="ltr">
            <li>{{$val_cart['name']}}</li>
            <!--<li>تذكرة  x 2</li>-->
        </ul>
    </td>
    <td>{!!getNum_rowChart($val_cart['row'])!!}</td>
    <td>{!!date("Y-m-d")!!}</td>
    <td>{!!conditionPrice(round($val_cart['price'] - (($val_cart['price'] * $val_cart['discount']) / 100), 2))!!} ريال</td>
    <td><a class="remove_cart_chair" id="remove_cart_chair" data-link="{{$val_cart['link']}}" data-name="{{$val_cart['name']}}"><i class="fa fa-trash  icon_remove" aria-hidden="true"></i></a></td>  
</tr>
@endforeach