@extends('admin.layouts.app')
@section('title') {{trans('app.add')}}{{trans('app.comment')}}  
@stop
@section('head_content')
@include('admin.productcomments.head')
@stop
@section('content')

@include('admin.errors.errors')
@if(isset($product->id))
{!! Form::open(array('route' => ['admin.products.comments.store', $product->id],'method'=>'POST','data-parsley-validate'=>"")) !!}
@include('admin.productcomments.form_create')
@else
{!! Form::open(array('route' => 'admin.productcomments.store','method'=>'POST','data-parsley-validate'=>"")) !!}
@include('admin.productcomments.form')
@endif
{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.productcomments.repeater')
@stop