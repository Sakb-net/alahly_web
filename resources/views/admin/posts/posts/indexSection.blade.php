@extends('admin.layouts.app')
@section('title') كل {{$type_name}}
@stop
@section('head_content')
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($post_create > 0)
            <a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="اضافة جديدة" href="{{ route('admin.posts.creat',$type) }}"></a>
            @endif
            <a class="btn btn-primary fa fa-search" data-toggle="tooltip" data-placement="top" data-title="بحث {{$type_name}}" href="{{ route('admin.posts.search',$type) }}"></a>
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
                    @if ($type == 'chair')
                    @include('admin.posts.posts.tableSection') 
                    @else
                    @include('admin.posts.posts.table') 
                    @endif

                </table>

                {{  $data->links() }}
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


