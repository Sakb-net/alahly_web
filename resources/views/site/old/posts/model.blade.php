<div id="myModal" class="modal fade sizeModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title draw_title_section"></h4>
            </div>
            <div class="modal-body ">
            <div class="mlab_chair draw_chair" id="draw_chair">
                @include('site.posts.chair')
                <!--<a href="#"><div class="circle active"></div></a>-->
                <!--<a href="#" style="pointer-events: none;"><div class="circle "></div><a>-->
                <!--<a href="#">
                    <div class="circle active" title="سعر التذكرة :100 ر.س" data-toggle="tooltip">
                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                    </div>
                </a>-->
            </div>
            </div>
            <div class="modal-footer">
                <div class="price-wrap pull-left">
                    <p class="tzaker">عدد التذاكر: <strong>0</strong> </p>
                    <!--<p>الشحن مجانا</p>-->
                    <h3 class="egmaly_price">إجمالي السعر: <strong class="value">0.00 ريال</strong></h3>
                </div>
                <a href="{{ route('profile.index') }}" class="butn butn-bg pull-right"><span>سلة المشتريات</span></a>
                <a href="{{ route('tickets.payment.match') }}" class="butn butn-bg btn_pay pull-right"><span>ادفع الآن</span></a>            </div>
        </div>
    </div>
</div>
