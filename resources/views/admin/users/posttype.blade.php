@extends('admin.layouts.app')
@section('head_content')
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            @if($name == 'posts' && $post_create == 1)
            <a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="اضافة مستخدم" href="{{ route('admin.posts.create') }}"></a>
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

                    @include('admin.layouts.posttype')

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


