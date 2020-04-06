@extends('admin.layouts.app')
@section('title') عرض العضو 
@stop
@section('head_content')
@include('admin.users.head')
@stop
@section('content')

<div class="row">
    <div class="box">
        <div class="box-body">


            <div class="form-group">

                <label>الاسم:</label>

                {{ $user->name }}

            </div>

            <div class="form-group">

                <label>الاسم الظاهر:</label>

                {{ $user->display_name }}

            </div>


            <div class="form-group">

                <label>البريد الالكترونى:</label>

                {{ $user->email }}

            </div>

            <div class="form-group">

                <label>الهاتف:</label>

                {{ $user->phone }}

            </div>

            <div class="form-group">

                <label>العنوان:</label>

                {{ $user->address }}

            </div>

            <div class="form-group">

                <label>الصورة:</label>

                <img  src="{{ $image }}"  width="20%" height="auto" @if($image == Null)  style="display:none;" @endif />


            </div>
            @if(Auth::user()->can('access-all','user-all'))


            <div class="form-group">
                <label>الوظائف:</label>
                @if(!empty($user->roles))
                @foreach($user->roles as $v)
                <label class="label label-success">{{ $v->display_name }}</label>
                @endforeach
                @endif
            </div>
            <div class="form-group">
                <label>الحالة:</label>
                {{ statusName($user->is_active) }}
            </div>
            @endif
        </div>
    </div>
</div>

@stop