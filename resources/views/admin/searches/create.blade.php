@extends('admin.layouts.app')
@section('title') اضافة بحث جديد 
@stop
@section('head_content')
@include('admin.searches.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.searches.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.searches.form')

{!! Form::close() !!}

@stop