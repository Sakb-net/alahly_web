@extends('admin.layouts.app')
@section('title') كل التعليقات
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($comment_create > 0)
            <a class="btn btn-success fa fa-plus"  data-toggle="tooltip" data-placement="top" data-title="تعليقات post" href="{{ route('admin.posts.comments.create',[$id]) }}"></a>
            @endif
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
                    @include('admin.layouts.comments')  
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


