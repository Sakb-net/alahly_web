@extends('admin.layouts.app')
@section('title') اضافة البوم جديد 
@stop
@section('head_content')
@include('admin.albums.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.albums.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.albums.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.albums.repeater')
@stop