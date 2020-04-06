@extends('admin.layouts.app')

@section('title')

   404 

@stop
@section('head_content')
 <h1>
        404 Error Page
      </h1>
@stop
@section('content')

  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->

     


    <!-- Main content -->
  
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="/admin">return to dashboard</a> or try using the search form.
          </p>

        </div>
        <!-- /.error-content -->


@stop