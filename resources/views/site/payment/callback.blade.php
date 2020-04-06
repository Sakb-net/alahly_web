@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <!--        <h2>ادفع الان</h2>-->
    </div> <!-- /.opacity -->
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- My Account Tab Menu Start -->
            <div class="col-md-12">
                <div class="myaccount-content">
                    <!--<h3>ادفع الان</h3>-->
                    <div style="margin-bottom: 100px"></div>
                    <div class="account-details-form">
                        <div class="col-md-12 col-xs-12 no-courses-found">
                            <div class="alert alert-info alert-dismissible" role="alert" style="color:#000; background:{{$back_color}} ">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="icon icon-info"></span>{{$mesage_pay}} 
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if(isset($type_button)&&$type_button=='product')
                            <a href="{{ route('categories.index') }}" class="butn butn-bg pull-right"><span>الذهاب للمتجر</span></a>
                            @else
                            <a href="{{ route('matches.next') }}" class="butn butn-bg pull-right"><span>الذهاب للمباريات القادمة</span></a>
                            @endif
                        </div>
                    </div>
                    <div style="margin-bottom: 100px"></div>
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
@stop  
