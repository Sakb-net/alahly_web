@extends('admin.layouts.app')
@section('title') تعديل الفريق 
@stop
@section('head_content')
@include('admin.teams.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($category, ['method' => 'PATCH','route' => ['admin.clubteams.update', $category->id],'data-parsley-validate'=>""]) !!}
@include('admin.teams.form')
{!! Form::close() !!}
@stop
@section('after_foot')
@include('admin.teams.repeater')
@stop