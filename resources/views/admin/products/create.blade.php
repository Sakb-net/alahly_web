@extends('admin.layouts.app')
@section('title') اضافة  جديدة 
@stop
@section('head_content')
@include('admin.products.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::open(array('route' => 'admin.products.store','method'=>'post','data-parsley-validate'=>"")) !!}

@include('admin.products.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.layouts.tinymce')
@include('admin.products.repeater')
@stop