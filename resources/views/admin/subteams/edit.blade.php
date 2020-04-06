@extends('admin.layouts.app')
@section('title') تعديل فريق فرعى 
@stop
@section('head_content')
@include('admin.subteams.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($category, ['method' => 'PATCH','route' => ['admin.subclubteams.update', $category->id],'data-parsley-validate'=>""]) !!}
@include('admin.subteams.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.subteams.repeater')
@stop