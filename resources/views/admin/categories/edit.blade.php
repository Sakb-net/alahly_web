@extends('admin.layouts.app')
@section('title') تعديل القسم 
@stop
@section('head_content')
@include('admin.categories.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($category, ['method' => 'PATCH','route' => ['admin.categories.update', $category->id],'data-parsley-validate'=>""]) !!}
@include('admin.categories.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.categories.repeater')
@stop