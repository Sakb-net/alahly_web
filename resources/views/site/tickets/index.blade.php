@extends('site.layouts.app')
@section('content')
    @auth
        @include('site.tickets.master')  
    @else
        @include('auth.login_form')
    @endauth
@endsection
