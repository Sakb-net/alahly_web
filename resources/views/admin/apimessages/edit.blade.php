@extends('admin.layouts.app')
@section('title') تعديل رسائل الموقع 
@stop
@section('head_content')
@include('admin.apimessages.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($apimessages, ['method' => 'PATCH','route' => ['admin.apimessages.update', $apimessages->id],'data-parsley-validate'=>""]) !!}
@include('admin.apimessages.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.apimessages.repeater')
@stop