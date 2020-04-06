@extends('admin.layouts.app')
@section('title') عرض نتايج بحث
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($search_create > 0 )
            <a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="اضافة البحث" href="{{ route('admin.searches.create') }}"></a>
            @endif
            <a class="btn btn-primary fa fa-tasks" data-toggle="tooltip" data-placement="top" data-title="نتائج البحث" href="{{ route('admin.searches.index') }}"></a>
            <a class="btn btn-primary fa fa-search" data-toggle="tooltip" data-placement="top" data-title="بحث نتائج البحث" href="{{ route('admin.searches.search') }}"></a>
        </div>
    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">	
                <table  id="datatable"  class='table table-bordered table-striped'>
                    @include('admin.searches.table_show')   
                </table>

                {{  $data->links() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('after_foot')
@include('admin.layouts.delete')
@stop


