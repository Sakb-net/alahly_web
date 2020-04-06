@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <h2>الصفحة الشخصية</h2>
    </div> <!-- /.opacity -->
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- My Account Tab Menu Start -->
            <div class="col-md-12">
                <div class="text-center">
                    <!--@include('errors.alerts')
                        @include('errors.errors')-->
                    @include('site.layouts.alert_save')
                </div>
                <div class="text-center mb-10">
                    @include('site.layouts.correct_wrong')
                </div>
                
                @include('site.profile.menu')
                <!-- My Account Tab Content Start -->
                <div class="tab-content col-sm-9" id="myTabContent">
                    <!-- Single Tab Content Start -->
                    @include('site.profile.mydata')
                    <!-- Single Tab Content End -->

                    <!-- Single Tab Content Start -->
                    @include('site.profile.myticket')
                    <!-- Single Tab Content End -->

                    <!-- Single Tab Content Start -->
                    @include('site.profile.update')
                    <!-- Single Tab Content End -->
                </div>
                <!-- My Account Tab Content End -->
            </div>
            <!-- My Account Tab Menu End -->
        </div>
    </div>
</section>
@include('site.tickets.model')
@endsection
@section('after_head')

@stop  
@section('after_foot')

@stop  
