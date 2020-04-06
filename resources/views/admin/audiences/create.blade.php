@extends('admin.layouts.app')
@section('title') اضافة  جديد 
@stop
@section('head_content')
@include('admin.audiences.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.audiences.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.audiences.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.audiences.repeater')
@stop