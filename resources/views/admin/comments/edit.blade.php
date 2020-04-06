@extends('admin.layouts.app')
@section('title') {{trans('app.update')}}   
@stop
@section('head_content')
@include('admin.comments.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($comment, ['method' => 'PATCH','route' => ['admin.comments.update', $comment->id],'data-parsley-validate'=>""]) !!}
@include('admin.comments.form')
{!! Form::close() !!}
@stop