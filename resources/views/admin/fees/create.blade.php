@extends('admin.layouts.app')
@section('title') اضافة  جديد 
@stop
@section('head_content')
@include('admin.fees.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.fees.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.fees.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.fees.repeater')
@stop