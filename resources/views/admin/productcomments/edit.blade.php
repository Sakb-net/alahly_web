@extends('admin.layouts.app')
@section('title') {{trans('app.update')}}   
@stop
@section('head_content')
@include('admin.productcomments.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($comment, ['method' => 'PATCH','route' => ['admin.blogcomments.update', $comment->id],'data-parsley-validate'=>""]) !!}
@include('admin.blogcomments.form')
{!! Form::close() !!}
@stop