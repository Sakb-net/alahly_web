@extends('admin.layouts.app')
@section('title') اضافة صلاحية جديد 
@stop
@section('head_content')
@include('admin.permissions.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.permission.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.permissions.form')

{!! Form::close() !!}

@stop