<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if(isset($product->id))
            <a class="btn btn-primary fa fa-tasks" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.comments')}} " href="{{ route('admin.products.comments.index',$product->id)}}"></a>
            @else
            <a class="btn btn-primary fa fa-tasks" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.comments')}} " href="{{ route('admin.productcomments.index') }}"></a>
            @endif
            <!--<a class="btn btn-info fa fa-search" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.search_comments')}} " href="{{ route('admin.productcomments.search') }}"></a>-->
        </div>
    </div>
</div>
