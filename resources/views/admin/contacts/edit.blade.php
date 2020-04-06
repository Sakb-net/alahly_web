@extends('admin.layouts.app')
@section('title') اضافة رد على الرسالة
@stop
@section('head_content')
@include('admin.contacts.head')
@stop
@section('content')
@include('admin.errors.errors')
{!! Form::model($contact, ['method' => 'PATCH','route' => ['admin.contacts.update', $contact->id],'data-parsley-validate'=>""]) !!}
@include('admin.contacts.form')
{!! Form::close() !!}
@stop