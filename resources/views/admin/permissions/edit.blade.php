@extends('admin.layouts.app')
@section('title') تعديل صلاحية 
@stop
@section('head_content')
@include('admin.permissions.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($permission, ['method' => 'PATCH','route' => ['admin.permission.update', $permission->id],'data-parsley-validate'=>""]) !!}
@include('admin.permissions.form')
{!! Form::close() !!}
@stop