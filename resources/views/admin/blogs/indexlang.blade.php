@extends('admin.layouts.app')
@section('title') {{trans('app.all')}}  {{trans('app.news')}} 
@stop
@section('head_content')
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
              @if($blog_create > 0)
                <a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.add')}}  {{trans('app.new_one')}}" href="{{ route('admin.blogs.create') }}"></a>
                <a class="btn btn-info fa fa-sort" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.arrange')}}   {{trans('app.news')}} " href="{{ route('admin.blogs.arrange.index') }}"></a>
                @endif
                <a class="btn btn-primary fa fa-search" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.search')}}  {{trans('app.news')}} " href="{{ route('admin.blogs.search') }}"></a>
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

                    @include('admin.blogs.table')  

                </table>

            </div>
        </div>
    </div>
</div>

@stop

@section('after_foot')
@include('admin.layouts.copy')
@include('admin.layouts.arrange')
@include('admin.layouts.stopShare')
@include('admin.layouts.delete')
@include('admin.layouts.status')
@stop


