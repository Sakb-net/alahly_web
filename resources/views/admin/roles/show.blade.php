@extends('admin.layouts.app')
@section('title') عرض الوظيفة 
@stop
@section('head_content')
@include('admin.roles.head')
@stop
@section('content')

<div class="row">

    <div class="box">
        <div class="box-body">

            <div class="form-group">

                <label>الاسم:</label>

                {{ $role->name }}

            </div>





            <div class="form-group">

                <label>الاسم الظاهر:</label>

                {{ $role->display_name }}

            </div>





            <div class="form-group">

                <label>الوصف:</label>

                {{ $role->description  }}

            </div>



            @if(Auth::user()->can('access-all', 'role-all','role-edit'))


            <div class="form-group">

                <label>الصلاحيات:</label>

                @if(!empty($role->permissions))

                @foreach($role->permissions as $v)

                <label class="label label-success">{{ $v->display_name }}</label>

                @endforeach

                @endif

            </div>


            
            @endif
        </div>
    </div>
</div>
@stop