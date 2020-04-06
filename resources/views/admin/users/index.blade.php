@extends('admin.layouts.app')
@section('title') كل الاعضاء
@stop
@section('head_content')
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($user_create == 1)
            <a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="اضافة مستخدم" href="{{ route('admin.users.create') }}"></a>
            @endif
            <a class="btn btn-primary fa fa-search" data-toggle="tooltip" data-placement="top" data-title="بحث المستخدمين" href="{{ route('admin.users.search') }}"></a>
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

                    @include('admin.users.table')   

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


