@extends('admin.layouts.app')

@section('title')

    <title>Unauthorized Exeption</title>

@stop
@section('head_content')
 <h1>
        Unauthorized Page
      </h1>
@stop
@section('content')

                <div class="error-page">


                    <div class="error-content">

                        <h2 class="text-red">No Way!</h2>
                        <h3><i class="fa fa-warning text-red"></i> Oops! You are not authorized to do this.</h3>

                        <p>
                            Meanwhile, you may <a href="/admin">return home</a>.
                        </p>


                    </div>
                    <!-- /.error-content -->
                </div>
                <!-- /.error-page -->


@stop