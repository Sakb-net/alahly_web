@extends('admin.layouts.app')
@section('title') تعديل سوال مجلس الجمهور 
@stop
@section('head_content')
@include('admin.audiences.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($category, ['method' => 'PATCH','route' => ['admin.audiences.update', $category->id],'data-parsley-validate'=>""]) !!}
@include('admin.audiences.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.audiences.repeater')
@stop