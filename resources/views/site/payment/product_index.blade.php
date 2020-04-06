@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <h2>ادفع الان</h2>
    </div> <!-- /.opacity -->
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- My Account Tab Menu Start -->
            <div class="col-md-12">
                <div class="myaccount-content">
                    <!--<h3>ادفع الان</h3>-->
                    <div class="account-details-form">
                        <form action="{{$shopperResultUrl}}" class="paymentWidgets" data-brands="VISA MASTER"></form>
                            <div class="row text-left">
                                <div class="col-md-6">
<!--                                    <input name="testMode" value="{{$testMode}}" type="hidden">
                                    <input name="merchantTransactionId" value="{{$merchantTransactionId}}" type="hidden">
                                    <input name="customer.email" value="{{$customer_email}}" type="hidden">
                                    <input name="billing.street1" value="{{$billing_street1}}" type="hidden">
                                    <input name="billing.city" value="{{$billing_city}}" type="hidden">
                                    <input name="billing.state" value="{{$billing_state}}" type="hidden">
                                    <input name="billing.country" value="{{$billing_country}}" type="hidden">
                                    <input name="billing.postcode" value="{{$billing_postcode}}" type="hidden">
                                    <input name="customer.givenName" value="{{$customer_givenName}}" type="hidden">
                                    <input name="customer.surname" value="{{$customer_surname}}" type="hidden">-->
                                </div>
                            </div>
                        </form>
                        <!--<div style="margin-bottom: 100px"></div>-->
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
