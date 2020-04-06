
<div class="raw appoint-repeater">
    <div  data-repeater-list="appoint" >
        @if(count($all_appoint)!=0)
        @foreach ($all_appoint as $key => $appoint)
        <div  data-repeater-item>
            <div class="col-sm-11 col-md-11 col-lg-11">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <label>من اليوم</label>
                    {!! Form::text('dayFrom', $appoint->meta_key, array('class' => 'form-control')) !!}
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <label>الى اليوم</label>
                    {!! Form::text('dayTo', $appoint->meta_value, array('class' => 'form-control')) !!}
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                    <label>من </label>
                    {!! Form::text('hourFrom', $appoint->meta_etc, array('class' => 'form-control')) !!}
                </div> 

                <div class="col-sm-3 col-md-3 col-lg-3">
                    <label>الى </label>
                    {!! Form::text('hourTo', $appoint->meta_other, array('class' => 'form-control')) !!}
                </div>
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
    <!--dispaly appoint-->               
    <div class="clearfix m-b"></div>
    <div class="col-md-3 col-sm-4">
        <input  type="button" class="btn btn-success btn-s-xs appoint-add-show" value="اضافة  موعد"/>
    </div>
    <div class="clearfix"></div>
    <div class="raw appoint-add-repeater hide">
        <div  data-repeater-list="appoint_add" >
            <div  data-repeater-item>
                <div class="col-sm-11 col-md-11 col-lg-11">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <label>من اليوم</label>
                        {!! Form::text('dayFrom', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <label>الى اليوم</label>
                        {!! Form::text('dayTo', null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <label>من </label>
                        {!! Form::text('hourFrom', null, array('class' => 'form-control')) !!}
                    </div> 

                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <label>الى </label>
                        {!! Form::text('hourTo', null, array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-sm-1 bi-input">
                    <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                </div> 
                <div class="clearfix m-b"></div> <hr/>
            </div>
        </div>

        <div class="col-sm-4  m-b">
            <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  موعد"/>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

