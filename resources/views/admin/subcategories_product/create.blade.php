@extends('admin.layouts.app')
@section('title') اضافة قسم جديد فرعى 
@stop
@section('head_content')
@include('admin.subcategories_product.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.subcategories_product.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.subcategories_product.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.subcategories_product.repeater')
@stop