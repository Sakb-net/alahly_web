@extends('admin.layouts.app')
@section('title') {{trans('app.all')}}  {{trans('app.comments')}} 
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
             @if($comment_create > 0)
             @if(isset($blog->id))
            <a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.add')}}  " href="{{ route('admin.blogs.comments.create',$blog->id) }}"></a>
            @else
            <!--<a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.add')}}  " href="{{ route('admin.blogcomments.create') }}"></a>-->
            @endif 
            <!--<a class="btn btn-info fa fa-sort" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.arrange')}}   {{trans('app.comments')}} " href=""></a>-->
            @endif
            <!--<a class="btn btn-primary fa fa-search" href="{{ route('admin.blogcomments.search') }}"></a>-->
            <a id="MakeallRead" data-id='0' data-name='{{trans('app.all_view')}}' class="btn btn-success fa fa-eye btn-order" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.all_view')}} "  style="background-color:#306302; "></a>
            {!! Form::open(['method' => 'post','route' => ['admin.blogcomments.allread'],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-allRead-id' => 0]) !!}
            {!! Form::close() !!}
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
                    @include('admin.blogcomments.table')    
                </table>
                {{  $data->links() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('after_foot')
@include('admin.layouts.delete')
@include('admin.layouts.allRead')
@include('admin.layouts.status')
@stop


