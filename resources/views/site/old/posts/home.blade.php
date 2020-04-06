@extends('site.layouts.app')
@section('content')
    @auth
        @include('site.posts.master')  
    @else
        @include('auth.login_form')
    @endauth
@endsection
