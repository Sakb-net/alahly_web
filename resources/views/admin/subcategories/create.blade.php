@extends('admin.layouts.app')
@section('title') اضافة قسم جديد فرعى 
@stop
@section('head_content')
@include('admin.subcategories.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.subcategories.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.subcategories.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.subcategories.repeater')
@stop