<footer class="myfooter wow fadeInUp">
    <div class="container">
        <div class="top-footer row">
            <div class="col-md-2 hidden-sm col-xs-12 footer-list">
                <img src="{{ asset('images/logo/footer-logo.png')}}" alt="{{$title}}"/>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <h6>من نحن</h6>
                <p>{!!$description!!}</p>
                @include('site.layouts.social_icon')
            </div>
            <div class="col-sm-3">
                <h6>تحميل التطبيق</h6>
                <div class="store">
                    <ul class="list-inline">
                        <li><a href="#"><i class="fa fa-android"></i></a></li>
                        <li><a href="#"><i class="fa fa-apple"></i></a></li>
                    </ul>
                    <p>متوفر على نظامي iOS , Android</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-5 col-xs-12 footer-list">
                @include('site.layouts.subscribe')
            </div>
        </div>
        <!-- /.top-footer -->
    </div>
    <!-- /.container -->
</footer>
<div class="bottom-footer">
    <div class="container">
        <div class="copyright col-md-6">
            <p>جميع الحقوق محفوظة شركة <a href="http://sakb.net/">Sakb</a> © {{date("Y")}}</p>
        </div>
        <div class="payment-method col-md-6">
            <img class="center-block" src="{{ asset('images/payment-method.png')}}" alt="">
        </div>
    </div>
    <!-- /.container -->
</div>
<!-- Scroll Top Button -->
<button class="scroll-top tran3s">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</button>
