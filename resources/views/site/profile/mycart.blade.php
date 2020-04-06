<div class="myaccount-content">
    <h3>سلة المشتريات</h3>
    <div class="myaccount-table table-responsive text-center">
        <table class="table table-bordered">
            @include('site.profile.header_cart')
            <tbody class="draw_cart_chair" id="draw_cart_chair">
                @if($count_cart>0)
                    @include('site.profile.body_cart')
                @else
                    @include('site.profile.body_empty')
                @endif
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <div class="price-wrap pull-left">
            <p class="tzaker">عدد التذاكر: <strong>{{$count_cart}}</strong> </p>
            <!--<p>الشحن مجانا</p>-->
            <h3 class="egmaly_price">إجمالي السعر: <strong class="value">{{$price_cart}} ريال</strong></h3>
        </div>
        <a href="{{ route('tickets.payment.match') }}" class="butn butn-bg pull-right"><span>ادفع الآن</span></a>
    </div>
</div>