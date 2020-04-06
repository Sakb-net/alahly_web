@extends('admin.layouts.app')
@section('title') {{trans('app.update')}}  {{trans('app.role')}}  
@stop
@section('head_content')
@include('admin.roles.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($role, ['method' => 'PATCH','route' => ['admin.roles.update', $role->id],'data-parsley-validate'=>""]) !!}
@include('admin.roles.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.roles.repeater')
@stop
