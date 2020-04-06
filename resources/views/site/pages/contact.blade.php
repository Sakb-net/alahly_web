@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="contact section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact-info">
                    <div class="section-title">
                        <h2>بيانات الاتصال</h2>
                    </div>
                    <div class="item">
                        <i class="icon fa fa-tablet" aria-hidden="true"></i>
                        <div class="cont">
                            <h6>الهاتف : </h6>
                            <p>{{$phone}}</p>
                        </div>
                    </div>
                    <div class="item">
                        <i class="icon fa fa-envelope-o" aria-hidden="true"></i>
                        <div class="cont">
                            <h6>البريد الإلكتروني : </h6>
                            <p>{{$email}}</p>
                        </div>
                    </div>
                    <div class="item">
                        <i class="icon fa fa-map-marker" aria-hidden="true"></i>
                        <div class="cont">
                            <h6>العنوان: </h6>
                            <p>{{$address}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @include('site.pages.contact_form')
        </div>
    </div>
</section>
<!--============map=========-->
<div class="mapouter">
    <div class="container">
        <!-- Google map -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdEPAHqgxFK5pioDAB3rsvKchAtXxRGO4&callback=initMap"></script>
        <script type="text/javascript">
            function initMap() {
                var mylocation = {lat:<?php echo $lat;?>, lng:<?php echo $long;?> };
//                var mylocation = {lat:21.485811000000126, lng: 39.19971457783208};
//                var mylocation = {lat: 30.071275, lng: 31.357565};
                var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 12,
                  center: mylocation
                });
                var marker = new google.maps.Marker({
                  position: mylocation,
                  map: map
                });
              }
        </script>
        <div id="map" style="width:100%; height:350px;"></div>
    </div>
</div>
@endsection
