@extends('admin.layouts.app')
@section('title') {{trans('app.add')}}  {{trans('app.role')}}  {{trans('app.new')}}  
@stop
@section('head_content')
@include('admin.roles.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::open(array('route' => 'admin.roles.store','method'=>'POST','data-parsley-validate'=>"")) !!}
@include('admin.roles.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.roles.repeater')
@stop