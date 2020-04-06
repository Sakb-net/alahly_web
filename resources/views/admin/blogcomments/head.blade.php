<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if(isset($blog->id))
            <a class="btn btn-primary fa fa-tasks" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.comments')}} " href="{{ route('admin.blogs.comments.index',$blog->id)}}"></a>
            @else
            <a class="btn btn-primary fa fa-tasks" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.comments')}} " href="{{ route('admin.blogcomments.index') }}"></a>
            @endif
            <!--<a class="btn btn-info fa fa-search" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.search_comments')}} " href="{{ route('admin.blogcomments.search') }}"></a>-->
        </div>
    </div>
</div>
