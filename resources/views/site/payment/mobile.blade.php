@extends('site.layouts.app_mobile')
@section('content')
<div class="myinner-banner">
    <div class="opacity" style="background:#03a960;padding: 0px 0 20px 0;">
         <!--#00703f;-->
        <h2>ادفع الان</h2>
    </div>  
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- My Account Tab Menu Start -->
            <div class="col-md-12">
                <div class="myaccount-content">
                    <!--<h3>ادفع الان</h3>-->
                    <div class="account-details-form">
                        <form action="{{$shopperResultUrl}}" class="paymentWidgets" data-brands="VISA MASTER">
                        </form>
                       <div style="margin-bottom: 200px"></div>
                    </div>
                </div>
            </div>
            <!-- My Account Tab Menu End -->
        </div>
    </div>
</section>
@endsection
@section('after_head')
@stop  
@section('after_foot')
<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkoutId}}"></script>
@stop  
