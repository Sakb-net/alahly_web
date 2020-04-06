@extends('admin.layouts.app')
@section('title') تعديل الروزنامة 
@stop
@section('head_content')
@include('admin.calendar.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($calendar, ['method' => 'PATCH','route' => ['admin.calendar.update', $calendar->id],'data-parsley-validate'=>""]) !!}
@include('admin.calendar.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.calendar.repeater')
@stop