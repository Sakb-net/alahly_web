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
                    <h3>{{ $user_count }}</h3>
                    <p>كل سجل الزوار</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
                <a href="{{ route('admin.contacts.type','visitor') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $user_count_day }}</h3>
                    <p>زائر جديدة</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.contacts.type','visitor') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $user_count_month }}</h3>
                    <p>سجل الزوار اخر شهر</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="{{ route('admin.contacts.type','visitor') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $user_count_week }}</h3>

                    <p>سجل الزوار اخر اسبوع</p>
                </div>
                <div class="icon">
                    <i class="ion ion-man"></i>
                </div>
                <a href="{{ route('admin.contacts.type','visitor') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!--*****************************************-->

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $comment_count }}</h3>
                    <p>كل تعليق</p>
                </div>
                <div class="icon">
                    <i class="ion ion-chatbubbles"></i>
                </div>
                <a href="{{ route('admin.comments.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $comment_count_day }}</h3>
                    <p>تعليق جديدة</p>
                </div>
                <div class="icon">
                    <i class="ion ion-chatbubble-working"></i>
                </div>
                <a href="{{ route('admin.comments.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $comment_count_month }}</h3>
                    <p>تعليق اخر شهر</p>
                </div>
                <div class="icon">
                    <i class="ion ion-chatbubble"></i>
                </div>
                <a href="{{ route('admin.comments.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $comment_count_week }}</h3>

                    <p>تعليق اخر اسبوع</p>
                </div>
                <div class="icon">
                    <i class="ion ion-chatbubble"></i>
                </div>
                <a href="{{ route('admin.comments.index') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!--***************************************-->

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $contact_count }}</h3>
                    <p>كل رسائل اتصل بنا</p>
                </div>
                <div class="icon">
                    <i class="ion ion-email"></i>
                </div>
                <a href="{{ route('admin.contacts.type','contact') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $contact_count_day }}</h3>
                    <p>رسائل اتصل بنا جديدة</p>
                </div>
                <div class="icon">
                    <i class="ion ion-email-unread"></i>
                </div>
                <a href="{{ route('admin.contacts.type','contact') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $contact_count_month }}</h3>
                    <p>رسائل اتصل بنا اخر شهر</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bookmark"></i>
                </div>
                <a href="{{ route('admin.contacts.type','contact') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $contact_count_week }}</h3>

                    <p>رسائل اتصل بنا اخر اسبوع</p>
                </div>
                <div class="icon">
                    <i class="ion ion-paper-airplane"></i>
                </div>
                <a href="{{ route('admin.contacts.type','contact') }}" class="small-box-footer">مشاهدة الكل <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!--***************************************-->
        
    </div>
</section>
@stop
