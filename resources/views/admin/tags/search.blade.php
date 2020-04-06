@extends('admin.layouts.app')
@section('title') بحث كل الوسم
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($tag_create > 0 )
            <a class="btn btn-success fa fa-plus" href="{{ route('admin.tags.create') }}"></a>
            @endif
            <a class="btn btn-primary fa fa-tasks" href="{{ route('admin.tags.index') }}"></a>
        </div>

    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">	
                <table  id="datatable_search" data-page-length='50' class='table table-bordered table-striped'>
                 @include('admin.tags.table')   
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('after_foot')
@include('admin.layouts.delete')

@stop

