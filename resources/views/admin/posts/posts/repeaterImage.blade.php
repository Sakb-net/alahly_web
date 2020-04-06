<div class="panel-body">
    <div class="ool-sm-12">
        <!--<h3> الصورة</h3>-->    
    </div>
    <div class="raw brand-repeater">
        <div  data-repeater-list="brand" >
             @if(count($all_brand)!=0)
             @foreach ($all_brand as $key => $brand)
            <div  data-repeater-item>
                <div class="col-sm-11">
                    <input id="image_link{{$key}}" name="value_image" type="hidden" value="{{$brand->meta_value}}">
                    <img  src="{{$brand->meta_value}}"  width="80%" height="100px" @if($brand->meta_value == '') style="display:none;" @endif  />
                       @if($post_active == 1)
                        <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image_link'.$key)}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                        @else
                        <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image_link'.$key)}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                        @endif  
                    <a href="#" class="btn btn-danger btn-s-xs fa fa-remove remove_image_link hidden" type="button"></a>
                    <input class="image_number" type="hidden" value="{{$key}}">
                    <input type="hidden" name="post_meta_id" value="{{$brand->id}}" class="form-control m-b" >
                </div> 
                <div class="col-sm-1 bi-input">
                    <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                </div> 
                <div class="clearfix m-b"></div>  
            </div>
               @endforeach
            @endif
        </div>
    </div>
    <div class="clearfix m-b"></div>
    <div class="col-md-3 col-sm-4">
        <input  type="button" class="btn btn-success btn-s-xs brand-add-show" value="اضافة  صورة"/>
    </div>
    <div class="clearfix"></div>
    <div class="raw brand-add-repeater hide">
        <div  data-repeater-list="brand_add" >
            <div  data-repeater-item>
                <div class="col-sm-11">
                    <input id="image_link" name="value_image" type="hidden">
                    <img  src=""  width="80%" height="100px" style="display:none;" />
                    @if($post_active == 1)
                    <a href="{{URL::asset('filemanager/dialog.php?type=1&akey=admin_panel&field_id=image_link')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @else
                    <a href="{{URL::asset('filemanager/dialog.php?type=0&akey=user&field_id=image_link')}}" class="btn iframe-btn btn-success fa fa-download" type="button"></a>
                    @endif
                    <a href="#" class="btn btn-danger btn-s-xs fa fa-remove remove_image_link hidden" type="button"></a>
                    <input class="image_number" type="hidden" value="1">

                </div> 
                <div class="col-sm-1 bi-input">
                    <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                </div> 
                <div class="clearfix"></div>  
            </div>
        </div>
       <div class="clearfix m-b"></div>
        <div class="col-sm-4  m-b">
            <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  صورة"/>
        </div>
    </div>
    <div class="clearfix"></div>
</div>