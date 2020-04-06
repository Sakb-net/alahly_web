@extends('admin.layouts.app')
@section('title') تعديل لاعب  
@stop
@section('head_content')
@include('admin.userteams.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($category, ['method' => 'PATCH','route' => ['admin.userclubteams.update', $category->id],'data-parsley-validate'=>""]) !!}
@include('admin.userteams.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.userteams.repeater')
@stop