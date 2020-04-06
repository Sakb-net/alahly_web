@extends('admin.layouts.app')
@section('title') كل المشاركات
@stop
@section('head_content')
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($post_create > 0)
            <a class="btn btn-success fa fa-plus" href="{{ route('admin.posts.create') }}"></a>
            @endif
            <a class="btn btn-primary fa fa-search" href="{{ route('admin.posts.search') }}"></a>
        </div>

    </div>

</div>
@stop
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">	

                @include('admin.errors.alerts')

                <table  id="datatable"  class='table table-bordered table-striped'>

                    @include('admin.layouts.posttype')  

                </table>

                {{  $data->links() }}
            </div>
        </div>
    </div>
</div>

@stop

@section('after_foot')
@include('admin.layouts.delete')
@include('admin.layouts.status')
@stop


