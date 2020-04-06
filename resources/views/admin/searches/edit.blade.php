@extends('admin.layouts.app')
@section('title') تعديل البحث 
@stop
@section('head_content')
@include('admin.searches.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($search, ['method' => 'PATCH','route' => ['admin.searches.update', $search->id],'data-parsley-validate'=>""]) !!}
@include('admin.searches.form')
{!! Form::close() !!}
@stop