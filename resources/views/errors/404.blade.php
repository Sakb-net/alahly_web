@extends('site.layouts.app',['title' => '404'])
@section('content')
<div class="myinner-banner">
    <div class="opacity">
       <h2>صفحة 404</h2>
    </div>
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="myaccount-content">
                    <h3>صفحة 404</h3>
                    <div style="margin-bottom: 100px"></div>
                    <div class="account-details-form">
                        <p class="text-center">
                            الصفحة التى تبحث عنها غير موجودة
                            <br>
                            <a href="{{ route('home') }}">العودة الى الرئيسية</a>.
                        </p>
                    </div>
                    <div style="margin-bottom: 100px"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('after_foot')
<script>
    $(document).ready(function () {
        $('body').find('.bottom-footer').addClass('footer_style');
        $('body').find('.bottom-footer').css({ "position": "static", "background": "#000" });;
    });
</script>
@stop  