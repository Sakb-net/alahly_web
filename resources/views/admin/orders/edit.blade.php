@extends('admin.layouts.app')
@section('title') {{trans('app.update')}}  {{trans('app.share')}}  
@stop
@section('head_content')
@include('admin.orders.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($order, ['method' => 'PATCH','route' => ['admin.orders.update', $order->id],'data-parsley-validate'=>""]) !!}
@include('admin.orders.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.orders.repeater')
@stop