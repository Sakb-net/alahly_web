@extends('admin.layouts.app')
@section('title') تعديل البطولة 
@stop
@section('head_content')
@include('admin.champions.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($category, ['method' => 'PATCH','route' => ['admin.champions.update', $category->id],'data-parsley-validate'=>""]) !!}
@include('admin.champions.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.champions.repeater')
@stop