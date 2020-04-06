@extends('admin.layouts.app')
@section('title') الاعدادات@stop
@section('content')

@include('admin.errors.errors')
@include('admin.errors.alerts')

{!! Form::open(array('route' => 'admin.options.store','method'=>'POST','data-parsley-validate'=>"")) !!}

<div class="row">
    <div class="col-sm-6">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>اسم الموقع:</label>
                    {!! Form::text('site_title', $site_title, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>رابط الموقع:</label>
                    {!! Form::text('site_url', $site_url, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>رابط لوحة الادمن:</label>
                    {!! Form::text('admin_url', $admin_url, array('class' => 'form-control','required'=>'','data-parsley-type'=>"alphanum")) !!}
                </div>              
                <div class="form-group hidden">
                    <label>رسالة البنر:</label>
                    {!! Form::text('message_banner', $message_banner, array('class' => 'form-control')) !!}
                </div>              
                <div class="form-group">
                    <label>الوصف</label>
                    {!! Form::textarea('description', $description, array('class' => 'form-control','rows'=>'4')) !!}
                </div>
                <div class="form-group hidden">
                    <label>الفيس بوك:</label>
                    {!! Form::text('facebook', $facebook, array('class' => 'form-control','data-parsley-type'=>"url")) !!}
                </div>
                <div class="form-group hidden">
                    <label>توتير:</label>
                    {!! Form::text('twitter', $twitter, array('class' => 'form-control','data-parsley-type'=>"url")) !!}
                </div>
                <div class="form-group hidden">
                    <label>يوتيوب:</label>
                    {!! Form::text('youtube', $youtube, array('class' => 'form-control','data-parsley-type'=>"url")) !!}
                </div>
                <div class="form-group hidden">
                    <label>جوجل بلس:</label>
                    {!! Form::text('googleplus', $googleplus, array('class' => 'form-control','data-parsley-type'=>"url")) !!}
                </div>
                <div class="form-group hidden">
                    <label>انستجرام:</label>
                    {!! Form::text('instagram', $instagram, array('class' => 'form-control','data-parsley-type'=>"url")) !!}
                </div>
                <div class="form-group hidden">
                    <label>واتس اب:</label>
                    {!! Form::text('whatsapp', $whatsapp, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label>حالة العضو الافتراضية:</label>
                    {!! Form::select('user_active',statusType() ,$user_active, array('class' => 'select2')) !!}
                </div>
                <div class="form-group">
                    <label>الوظيفة الافتراضية للاعضاء:</label>
                    {!! Form::select('default_role',$roles ,$default_role, array('class' => 'select2')) !!}
                </div>
                <div class="form-group">
                    <label>عرض Posts:</label>
                    {!! Form::text('pagi_limit',$pagi_limit ,array('class' => 'form-control','required'=>'','data-parsley-type'=>"number")) !!}
                </div>
                <div class="form-group">
                    <label>رساله غلق الموقع 1:</label>
                    {!! Form::text('msgmain_close', $msgmain_close, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label>رساله غلق الموقع2:</label>
                    {!! Form::text('message_close', $message_close, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label>الموقع مفتوح:</label>
                    {!! Form::select('site_open',showType() ,$site_open, array('class' => 'select2')) !!}
                </div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>صورة اللوجو:</label><br>
                    <input id="logo_image" name="logo_image" type="hidden" value="{{ $logo_image }}">
                    <img  src="{{ $logo_image }}"  width="40%" height="auto" @if($logo_image == Null)  style="display:none;" @endif />
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=logo_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                <div class="form-group">
                    <label>صورة المشاركة على مواقع التواصل:</label><br>
                    <input id="share_image" name="share_image" type="hidden" value="{{ $share_image }}">
                    <img  src="{{ $share_image }}"  width="40%" height="auto" @if($share_image == Null)  style="display:none;" @endif />
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=share_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                <div class="form-group">
                    <label>الصورة الافتراضية:</label><br>
                    <input id="default_image" name="default_image" type="hidden" value="{{ $default_image }}">
                    <img  src="{{ $default_image }}"  width="40%" height="auto" @if($default_image == Null)  style="display:none;" @endif />
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=default_image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                <div class="form-group hidden">
                    <label>كلمات البحث</label>
                    {!! Form::textarea('keywords', $keywords, array('class' => 'form-control','rows'=>'1')) !!}
                </div>
                <div class="form-group">
                    <label>كود فيس بوك بيكسل:</label>
                    {!! Form::textarea('facebook_pixel', $facebook_pixel, array('class' => 'form-control','rows'=>'5')) !!}
                </div>
                <div class="form-group">
                    <label>كود احصائيات جوجل:</label>
                    {!! Form::textarea('google_analytic', $google_analytic, array('class' => 'form-control','rows'=>'5')) !!}
                </div>    
            </div>
        </div>
    </div>

</div>


{!! Form::close() !!}

@stop
@section('after_foot')
<script type="text/javascript">

    $('body').on('click', '.remove_image_link', function () {
        $(this).prev().prev().prev().val('');
        $(this).prev().prev().attr('src', '').hide();
    });

    $('.iframe-btn').fancybox({
        'type': 'iframe',
        maxWidth: 900,
        maxHeight: 600,
        fitToView: true,
        width: '100%',
        height: '100%',
        autoSize: false,
        closeClick: true,
        closeBtn: true
    });

    function responsive_filemanager_callback(field_id) {
//        alert(field_id);
        $('#' + field_id).next().attr('src', document.getElementById(field_id).value).show();
        parent.$.fancybox.close();

    }

</script>

@stop

