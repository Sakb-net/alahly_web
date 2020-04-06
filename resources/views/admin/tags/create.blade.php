@extends('admin.layouts.app')
@section('title') اضافة وسم جديد 
@stop
@section('head_content')
@include('admin.tags.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.tags.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.tags.form')

{!! Form::close() !!}

@stop