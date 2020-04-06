<div class="box-body">
    <div class="raw itemvote-repeater">
        <div  data-repeater-list="itemvote" >
            @if(count($all_itemvote)!=0)
            @foreach ($all_itemvote as $key => $itemvote)
            <div  data-repeater-item>
                <div class="col-sm-11 col-md-11 col-lg-11">
                    <label>الجواب / الخيار</label>
                    {!! Form::text('answer', $itemvote->name, array('class' => 'form-control')) !!}
                    {!! Form::hidden('id',$itemvote->id) !!}
                </div>
                <div class="col-sm-1 bi-input">
                    <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                </div> 
            </div> 
            @endforeach
            @endif
        </div>
    </div>
    <div class="box-body">
        <!--dispaly itemvote-->               
        <div class="clearfix m-b"></div>
        <div class="col-md-3 col-sm-4">
            <input  type="button" class="btn btn-success btn-s-xs itemvote-add-show" value="اضافة  جديدة"/>
        </div>
        <div class="clearfix"></div>
        <div class="raw itemvote-add-repeater hide">
            <div  data-repeater-list="itemvote_add" >
                <div  data-repeater-item>
                    <div class="col-sm-11 col-md-11 col-lg-11">
                        <label>الجواب / الخيار</label>
                        {!! Form::text('answer', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-sm-1 bi-input">
                        <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                    </div> 
                    <div class="clearfix m-b"></div> 
                </div>
            </div>

            <div class="col-sm-4  m-b">
                <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  جديدة"/>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

