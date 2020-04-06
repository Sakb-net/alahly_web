@extends('admin.layouts.app')
@section('title') {{trans('app.search')}}  {{trans('app.all')}}  {{trans('app.comments')}} 
@stop
@section('head_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
              @if($comment_create > 0)
            <!--<a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="اضافة  " href="{{ route('admin.videocomments.create') }}"></a>-->
             <!--<a class="btn btn-info fa fa-sort" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.arrange')}}   {{trans('app.comments')}} " href=""></a>-->
            @endif
            <a class="btn btn-primary fa fa-tasks" href="{{ route('admin.videocomments.index') }}"></a>
        </div>

    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a aria-expanded="true" href="#members" data-toggle="tab">{{trans('app.search')}}  {{trans('app.comments')}} <i class="fa"></i></a></li>
                    <!--<li><a aria-expanded="true" href="#nots" data-toggle="tab">{{trans('app.comments')}}  {{trans('app.not')}} {{trans('app.active')}}  <i class="fa"></i></a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="members">
                        <form id="member_request"  onsubmit="return false;" method="post" role="form" autocomplete="off" data-validate="parsley">   
                            <div class="row">
                                <div class="form-group col-sm-5">
                                    <input type="text" id="searchInput"  name="data_value" class="form-control searchInput" placeholder=" {{trans('app.data')}} {{trans('app.search')}} " />
                                    <input type="hidden" id="searchType"  name="type_value" class="form-control searchType" value="comment" />
                                </div> 
                                <div class="form-group col-sm-2">
                                    <!--<label for="search">{{trans('app.search')}}  {{trans('app.comments')}} </label>-->
                                    <button type="submit" name="search" id="searchCommentBtn" class="btn btn-primary searchCommentBtn"><i class="fa fa-search"></i> {{trans('app.search')}} </button>
                                </div>
                            </div>
                        </form>
                        <div class="member_requests">@include('admin.layouts.search_ajax')</div>
                    </div>
                    <!--there another-->
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('after_foot')
@include('admin.layouts.delete')
@include('admin.layouts.status')
@stop

