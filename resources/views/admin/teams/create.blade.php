@extends('admin.layouts.app')
@section('title') اضافة فريق جديد 
@stop
@section('head_content')
@include('admin.teams.head')
@stop
@section('content')

@include('admin.errors.errors')

{!! Form::open(array('route' => 'admin.clubteams.store','method'=>'POST','data-parsley-validate'=>"")) !!}

@include('admin.teams.form')

{!! Form::close() !!}

@stop

@section('after_foot')
@include('admin.teams.repeater')
@stop