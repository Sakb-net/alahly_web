<div class="raw fees-repeater">
    <div  data-repeater-list="fees" >
        @if(count($all_fees)!=0)
        @foreach ($all_fees as $key => $val_fees)
        <div  data-repeater-item>
            <div class="col-sm-11 col-md-11 col-lg-11">
                <label>{{trans('app.fees')}} : </label>
                {!! Form::select('fees_id',$fees ,$val_fees, array('class' => 'select2 select ')) !!}
            </div>
            <div class="col-sm-1 bi-input">
                <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
            </div> 
        </div> 
        @endforeach
        @endif
    </div>
</div>
<!--**************************************************-->
<div class="box-body">
    <!--dispaly fees-->               
    <div class="clearfix m-b"></div>
    <div class="col-md-3 col-sm-4 hide">
        <input  type="button" class="btn btn-success btn-s-xs fees-add-show" value="اضافة  رسوم"/>
    </div>
    <div class="clearfix"></div>
    <div class="raw fees-add-repeater">
        <div  data-repeater-list="fees_add" >
            <div  data-repeater-item>
                <div class="col-sm-11 col-md-11 col-lg-11">
                    <label>{{trans('app.fees')}} : </label>
                    {!! Form::select('fees_id',$fees ,null, array('class' => 'select2 select ')) !!}
                </div>
                <div class="col-sm-1 bi-input">
                    <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                </div> 
                <div class="clearfix m-b"></div> <hr/>
            </div>
        </div>

        <div class="col-sm-4  m-b">
            <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  رسوم"/>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

