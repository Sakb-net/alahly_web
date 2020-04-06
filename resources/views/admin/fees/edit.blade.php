@extends('admin.layouts.app')
@section('title') تعديل الرسوم 
@stop
@section('head_content')
@include('admin.fees.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($fees, ['method' => 'PATCH','route' => ['admin.fees.update', $fees->id],'data-parsley-validate'=>""]) !!}
@include('admin.fees.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.fees.repeater')
@stop