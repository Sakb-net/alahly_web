@extends('admin.layouts.app')
@section('title') بحث اشتراك التذاكر
@stop
@section('head_content')
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($order_create > 0)
            <!--<a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="اضافة اشتراك جديدة" href="{{ route('admin.orders.create') }}"></a>-->
            @endif
            <a class="btn btn-primary fa fa-paint-brush" data-toggle="tooltip" data-placement="top" data-title="بحث الاشتركات" href="{{ route('admin.orders.index') }}"></a>
            
        </div>

    </div>

</div>
@stop
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">	
                <table  id="datatable_search"  data-page-length='50' class='table table-bordered table-striped'>
                @include('admin.orders.table')  
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('after_foot')
@include('admin.layouts.delete')
@include('admin.layouts.status')
@stop

