
<form class="form" method="post" action="#">
    <input type="hidden" value="{{$data['link']}}" class="form-control input_cat_sort" id="input_cat_sort">
    <div class="messages"></div>
    <div class="controls">
        <div class="row">
            @if(count($data['dec_prod'])>0)
            <div class="col-md-8">
                <div class="form-group">
                    <label>أختر المقاس:</label>
                    <select class="form-control select_weight_Product" id="select_weight_Product" required>
                        @foreach($data['dec_prod'] as $key_weight=>$val_weight)
                        <option value="{{$val_weight['code']}}" @if($data['price']==$val_weight['price']) selected="" @endif>{{$val_weight['weight']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            @if(count($data['color'])>0)
            <div class="col-md-8">
                <div class="form-group">
                    <label>الون:</label>
                    <select class="form-control select_color_Product" id="select_color_Product" required>
                        @foreach($data['color'] as $key_color=>$val_color)
                        <option value="{{$val_color['name']}}" >{{$val_color['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="col-md-8">
                <div class="form-group groub_name_print hidden">
                    <label>الاسم المطبوع:</label>
                    <span class="msg_name_print">من فضلك اضف اللاسم</span>
                    <input type="text" class="form-control name_print_Product" id="name_print_Product">
                </div>
                <div class="form-group">
                    @foreach($data['fees'] as $key_fees=>$val_fees)
                    <input type="checkbox" name="fees" value="{{$val_fees['link']}}" class="select_fees_Product" > 
                           {{$val_fees['name']}} <br>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12">
                <div class="pro-qty"><input type="text" class="quantity_numProduct" id="quantity_numProduct" value="1"></div>
                <input type="submit" class="add-to-cart-btn add_cart_productDetails" data-link="{{$data['link']}}" data-name="" value="أضف للسلة">
                <div class="bi-noti-upload"></div>
            </div>
        </div>
    </div>
</form>