@extends('admin.layouts.app')
@section('title') {{trans('app.add_question_comment')}}  
@stop
@section('head_content')
@include('admin.comments.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.comments.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.comments.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.comments.repeater')
@stop