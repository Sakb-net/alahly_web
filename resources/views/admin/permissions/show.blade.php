@extends('admin.layouts.app')
@section('title') عرض الصلاحية 
@stop
@section('head_content')
@include('admin.permissions.head')
@stop
@section('content')

<div class="row">

    <div class="box">
        <div class="box-body">

            <div class="form-group">

                <label>الاسم:</label>

                {{ $permission->name }}

            </div>





            <div class="form-group">

                <label>الاسم الظاهر:</label>

                {{ $permission->display_name }}

            </div>





            <div class="form-group">

                <label>الوصف:</label>

                {{ $permission->description  }}

            </div>



            @if(Auth::user()->can('access-all', 'permission-all','permission-edit'))


            <div class="form-group">

                <label>الصلاحيات:</label>

                @if(!empty($permission->permissions))

                @foreach($permission->permissions as $v)

                <label class="label label-success">{{ $v->display_name }}</label>

                @endforeach

                @endif

            </div>


            
            @endif
        </div>
    </div>
</div>
@stop