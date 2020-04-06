@extends('admin.layouts.app')
@section('title') عرض المنتج 
@stop
@section('head_content')
@include('admin.products.head')
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
                    {{ $product->name }}
                </div>
                <div class="form-group">
                    <label>الصورة:</label>
                    <img  src="{{ $product->image }}"  width="25%" height="auto" @if($product->image == Null)  style="display:none;" @endif />
                </div>
                <div class="form-group">
                    <label>المحتوى:</label>
                    {!! $product->content !!}
                </div>
                
                <div class="form-group">

                    <label>الملخص:</label>

                    {{ $product->excerpt }}

                </div>
                <div class="form-group">

                    <label>الوصف:</label>

                    {{ $product->description }}

                </div>
                @if(!empty($product->tags))
                <div class="form-group">
                    <label>الوسوم:</label>
                    @foreach($product->tags as $v)
                <label class="label label-success">{{ $v->name }}</label>
                @endforeach
                </div>
                @endif
                @if(!empty($product->categories))
                <div class="form-group">
                    <label>الاقسام:</label>
                    @foreach($product->categories as $v)
                <label class="label label-info">{{ $v->name }}</label>
                @endforeach
                </div>
                @endif
                @if($product_active > 0)
                <div class="form-group">
                    <label>التعليقات:</label>
                    {{ statusName($product->is_comment) }}
                </div>
                <div class="form-group">
                    <label>الحالة:</label>
                    {{ statusName($product->is_active) }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop