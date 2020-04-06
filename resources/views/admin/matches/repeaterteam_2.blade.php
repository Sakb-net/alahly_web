<div class="panel-body">
    <div class="ool-sm-12">
        <label> الفريق الثانى:</label>
    </div>
    <div class="raw second-repeater">
        <div  data-repeater-list="second" >
            @if(count($all_second)!=0)
            @foreach ($all_second as $key => $second)
            <div  data-repeater-item>
                <div class="col-sm-11">
                    <div class="row">
                        <div class="col-sm-12 col-md-9 col-lg-9 ">
                            <label> اسم الاعب:</label>
                            {!! Form::text('name_player', $second['name_player'], array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3 ">
                            <label> دقيقة الهدف:</label>
                            {!! Form::number('time_player', $second['time_player'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
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
        <input  type="button" class="btn btn-success btn-s-xs second-add-show" value="اضافة  "/>
    </div>
    <div class="clearfix"></div>
    <div class="raw second-add-repeater hide">
        <div  data-repeater-list="second_add" >
            <div  data-repeater-item>
                <div class="col-sm-11">
                    <div class="row">
                        <div class="col-sm-12 col-md-9 col-lg-9 ">
                            <label> اسم الاعب:</label>
                            {!! Form::text('name_player', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3 ">
                            <label> دقيقة الهدف:</label>
                            {!! Form::number('time_player', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div> 
                <div class="col-sm-1 bi-input">
                    <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                </div> 
                <div class="clearfix"></div>  
            </div>
        </div>
        <div class="clearfix m-b"></div>
        <div class="col-sm-4  m-b">
            <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  "/>
        </div>
    </div>
    <div class="clearfix"></div>
</div>