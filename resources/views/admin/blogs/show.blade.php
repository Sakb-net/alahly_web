@extends('admin.layouts.app')
@section('title') عرض المشاركة 
@stop
@section('head_content')
@include('admin.posts.head')
@stop
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">

                <div class="form-group">
                    <label>اسم الكاتب:</label>
                    {{ $user->display_name }}
                </div>
                <div class="form-group">
                    <label>الاسم:</label>
                    {{ $post->name }}
                </div>
                <div class="form-group">
                    <label>الصورة:</label>
                    <img  src="{{ $post->image }}"  width="25%" height="auto" @if($post->image == Null)  style="display:none;" @endif />
                </div>
                <div class="form-group">
                    <label>المحتوى:</label>
                    {!! $post->content !!}
                </div>
                
                <div class="form-group">

                    <label>الملخص:</label>

                    {{ $post->excerpt }}

                </div>
                <div class="form-group">

                    <label>الوصف:</label>

                    {{ $post->description }}

                </div>
                @if(!empty($post->tags))
                <div class="form-group">
                    <label>الوسوم:</label>
                    @foreach($post->tags as $v)
                <label class="label label-success">{{ $v->name }}</label>
                @endforeach
                </div>
                @endif
                @if(!empty($post->categories))
                <div class="form-group">
                    <label>الاقسام:</label>
                    @foreach($post->categories as $v)
                <label class="label label-info">{{ $v->name }}</label>
                @endforeach
                </div>
                @endif
                @if($post_active > 0)
                <div class="form-group">
                    <label>التعليقات:</label>
                    {{ statusName($post->is_comment) }}
                </div>
                <div class="form-group">
                    <label>الحالة:</label>
                    {{ statusName($post->is_active) }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop