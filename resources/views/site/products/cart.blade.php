@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="cart-table table-responsive">
            <div class="bi-cart-upload"></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="pro-thumbnail">صورة المنتج</th>
                        <th class="pro-title">اسم المنتج</th>
                        <th class="pro-price">السعر</th>
                        <th class="pro-quantity">الكمية </th>
                        <th class="pro-subtotal">الإجمالي</th>
                        <th class="pro-remove">حذف</th>
                    </tr>
                </thead>
                <tbody class="draw_cartProductTable">
                    @include('site.products.cart_draw')
                </tbody>
            </table>
            <table class="table_fees">
                <tbody class="draw_table_fees" id="draw_table_fees">
                   @foreach($cart_fees as $key_fees=>$val_fees)
                    <tr>
                        <td class="pro-title">{{$val_fees['name']}}</td>
                        <td class="pro-price"><span>{{ $val_fees['total_price']}} ريال</span></td>
                    </tr>
                    @php $total_price_cart +=$val_fees['total_price'] @endphp
                    @endforeach
                    <tr>
                        <td class="pro-title">الإجمالي</td>
                        <td class="pro-price"><span>{!! $total_price_cart !!} ريال</span></td>
                    </tr>
                </tbody>
            </table>
            <a href="{{route('categories.index')}}" class="butn butn-bg pull-left"><span>تكملة التسوق ...</span></a>
            <a href="{{route('products.checkout')}}" class="butn butn-bg pull-right"><span>الدفع الآن</span></a>
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
