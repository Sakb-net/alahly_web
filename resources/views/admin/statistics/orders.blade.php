@extends('admin.layouts.app')
@section('title') الصفحة الرئيسية@stop
@section('head_content')

@stop
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $order_count }}</h3>
                    <p>كل الاشتركات</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $order_count_month }}</h3>
                    <p>الاشتركات اخر شهر</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $order_count_week }}</h3>

                    <p>الاشتركات اخر اسبوع</p>
                </div>
                <div class="icon">
                    <i class="ion ion-man"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $order_count_day }}</h3>
                    <p>اشتركات جديدة</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $order_count_day }}</h3>
                    <p>اشتركات جديدة</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</section>
@stop
