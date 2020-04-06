@extends('admin.layouts.app')
@section('title') تعديل قسم فرعى 
@stop
@section('head_content')
@include('admin.subcategories_product.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($category, ['method' => 'PATCH','route' => ['admin.subcategories_product.update', $category->id],'data-parsley-validate'=>""]) !!}
@include('admin.subcategories_product.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.subcategories_product.repeater')
@stop