@extends('admin.layouts.app')
@section('title') تعديل العضو 
@stop
@section('head_content')
@include('admin.users.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->id],'data-parsley-validate'=>""]) !!}
@include('admin.users.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.users.repeater')

@stop