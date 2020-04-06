@extends('admin.layouts.app')
@section('title') {{trans('app.add')}}  {{trans('app.share')}}  {{trans('app.new')}}  
@stop
@section('head_content')
@include('admin.orders.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::open(array('route' => 'admin.orders.store','method'=>'post','data-parsley-validate'=>"")) !!}
@include('admin.orders.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.orders.repeater')
@stop