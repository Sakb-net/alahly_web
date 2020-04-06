@extends('admin.layouts.app')
@section('title') كل الرسائل
@stop
@section('head_content')
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($message_create > 0)
            <a class="btn btn-success fa fa-plus" href="{{ route('admin.messages.create') }}"></a>
            @endif

            <a class="btn btn-primary fa fa-search" href="{{ route('admin.messages.search') }}"></a>
            
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

                 @include('admin.messages.table')   

                </table>

                {{  $data->links() }}
            </div>
        </div>
    </div>
</div>

@stop



