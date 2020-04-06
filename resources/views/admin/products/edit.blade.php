@extends('admin.layouts.app')
@section('title') تعديل  
@stop
@section('head_content')
@include('admin.products.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($product, ['method' => 'PATCH','route' => ['admin.products.update', $product->id],'data-parsley-validate'=>""]) !!}
@include('admin.products.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.products.repeater')
@stop