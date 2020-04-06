@extends('admin.layouts.app')
@section('title') كل لاعبين الفريق
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($category_create > 0)
                @if(isset($parent_id))
                <a class="btn btn-success fa fa-plus"  data-toggle="tooltip" data-placement="top" data-title="اضافة الاعب / مدرب " href="{{ route('admin.userclubteams.creat',$parent_id) }}"></a>
                @else
                <!--<a class="btn btn-success fa fa-plus"  data-toggle="tooltip" data-placement="top" data-title="اضافة الاعب / مدرب " href="{{ route('admin.userclubteams.create') }}"></a>-->
                @endif
            @endif
            <a class="btn btn-primary fa fa-search"  data-toggle="tooltip" data-placement="top" data-title="بحث الاعبين " href="{{ route('admin.userclubteams.search') }}"></a>
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
                    @include('admin.userteams.table')   
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


