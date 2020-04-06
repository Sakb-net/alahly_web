@extends('admin.layouts.app')
@section('title') كل مجلس الجمهور 
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($category_create > 0)
            <a class="btn btn-success fa fa-plus"  data-toggle="tooltip" data-placement="top" data-title="اضافة جديدة " href="{{ route('admin.audiences.create') }}"></a>
            @endif
            <a class="btn btn-primary fa fa-search"  data-toggle="tooltip" data-placement="top" data-title="بحث مجلس الجمهور  " href="{{ route('admin.audiences.search') }}"></a>
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
                    @include('admin.audiences.table')   
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


