@extends('admin.layouts.app')
@section('title') عرض الرسائل 
@stop
@section('head_content')
@include('admin.contacts.head')
@stop
@section('content')

<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>الاسم:</label>
                    <label>{{ $contact->name }}</label>
                </div>
                @if($contact->type!='visitor')
                <div class="form-group">
                    <label>البريد الالكترونى:</label>
                    <label>{{ $contact->email }}</label>
                </div>
                @endif
                <div class="form-group">
                    <label>الرسالة:</label>
                    <label>{{ $contact->content }}</label>
                </div>
                <div class="box-footer text-center">
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop