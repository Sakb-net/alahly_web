@extends('admin.layouts.app')
@section('title') اضافة قسم جديد 
@stop
@section('head_content')
@include('admin.categories_product.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.categories_product.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.categories_product.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.categories_product.repeater')
@stop