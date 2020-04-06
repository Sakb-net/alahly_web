
<div class="raw decProd-repeater">
    <div  data-repeater-list="decProd" >
        @if(count($dec_prod)!=0)
        @foreach ($dec_prod as $key => $val_Prod)
        <div  data-repeater-item>
            <div class="col-sm-11 col-md-11 col-lg-11">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>تكلفة :</label>
                            {!! Form::number('price', $val_Prod['price'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>نسبة الخصم: (%)</label>
                            {!! Form::number('discount', $val_Prod['discount'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>كود المنتج:</label>
                            {!! Form::text('code', $val_Prod['code'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>مقاسات المنتج:</label>
                            {!! Form::text('weight', $val_Prod['weight'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1 bi-input">
                <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
            </div> 
            <div class="clearfix m-b"></div> <hr/>
        </div> 
        @endforeach
        @endif
    </div>
</div>
<!--**************************************************-->
<div class="box-body">
    <!--dispaly decProd-->               
    <div class="clearfix m-b"></div>
    <div class="col-md-3 col-sm-4  @if($new > 0 ) hide @endif">
        <input  type="button" class="btn btn-success btn-s-xs decProd-add-show" value="اضافة  صفات منتج"/>
    </div>
    <div class="clearfix"></div>
    <div class="raw decProd-add-repeater @if($new <= 0 ) hide @endif">
        <div  data-repeater-list="decProd_add" >
            <div  data-repeater-item>
                <div class="col-sm-11 col-md-11 col-lg-11">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>تكلفة :</label>
                                {!! Form::number('price', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                            <label>نسبة الخصم: (%)</label>
                                {!! Form::number('discount', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>كود المنتج:</label>
                                {!! Form::text('code', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>مقاسات المنتج:</label>
                                {!! Form::text('weight', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 bi-input">
                    <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                </div> 
                <div class="clearfix m-b"></div> <hr/>
            </div>
        </div>
        <div class="col-sm-4  m-b">
            <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  صفات منتج"/>
        </div>
    </div>
    <div class="clearfix"></div>
</div>