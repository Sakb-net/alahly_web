<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-primary fa fa-tasks" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.news')}} " href="{{ route('admin.blogs.index') }}"></a>
            <a class="btn btn-primary fa fa-search" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.search')}}  {{trans('app.news')}} " href="{{ route('admin.blogs.search') }}"></a>
        </div>
        <div class="pull-left">
            @if(isset($post_ar_name) && !empty($post_ar_name))
            <p><b>{{trans('app.arabic_language')}} : </b>{{$post_ar_name}}</p>
            @endif    </div>
    </div>

</div>
