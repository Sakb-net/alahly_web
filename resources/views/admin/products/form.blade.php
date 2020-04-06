<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                {!! Form::hidden('type',$type) !!}
                {!! Form::hidden('lang', $lang) !!}
                <div class="form-group">
                    <label>اسم المنتج:</label>
                    {!! Form::text('name', null, array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group hidden">
                    <label>الرابط:</label>
                    @if($new > 0 )
                    {!! Form::text('link', null, array('class' => 'form-control')) !!}
                    @else
                    {!! Form::text('link', null, array('class' => 'form-control','required'=>'')) !!}
                    @endif
                </div>
                <div class="form-group">
                    <label>{{trans('app.Category')}} : {{$lang}}</label>
                    {!! Form::select('category_id',$categories ,$productCategories, array('class' => 'select select2 ajax_get_subcategoryProduct','required'=>'')) !!}
                </div>
                @include('admin.products.ajax_get_subcategory')
                <div class="form-group">
                    <label>الوصف التفصيلى :</label>
                    <!--<label>نبذة مختصرة:</label>-->
                    <!--'id'=>'my-textarea'-->
                    {!! Form::textarea('description', null, array('class' => 'form-control','rows' => '5')) !!}
                </div>
                <div class="form-group">
                    <label>بلد الصنع:</label>
                    {!! Form::text('city_made', $city_made, array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label>الوان المنتج:</label>
                    {!! Form::select('color[]', $color,$color, array('class' => 'select2-tags','multiple')) !!}
                </div>
                <div class="form-group">
                    <label>العدد المتاح للمنتج:</label>
                    {!! Form::number('number_prod', null, array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                @include('admin.products.repeater_decProd')
                <div class="form-group hidden">
                    <label>الكلمات البحث:</label>
                    {!! Form::select('tags[]', $tags,$productTags, array('class' => 'select2-tags','multiple')) !!}
                </div>
                @if($new == 0 )
                @if($product_active > 0)
                <div class="form-group">
                    <label>الحالة:</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                </div>
                @endif
                @endif
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="box">
            <div class="box-body">
                @if($image == 1)
                <div class="form-group">
                    <label>الصورة الرئيسية للمنتج :</label>
                    <br>
                    <input id="image" name="image" type="hidden" value="{{ $image_link }}">
                    <img  src="{{ $image_link }}"  width="40%" height="auto" @if($image_link == Null)  style="display:none;" @endif />
                          @if($product_active == 1)
                          <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger fa fa-remove  remove_image_link" type="button"></a>
                </div>
                @endif
                <hr/>
                <div class="form-group">
                    <label>صور اخرى للمنتج :</label>
                    @include('admin.products.repeaterImage')
                </div>
                <hr/>
                <div class="form-group">
                    <label>الرسوم :</label>
                    @include('admin.products.fees')
                </div>
            </div>
        </div>
    </div>
