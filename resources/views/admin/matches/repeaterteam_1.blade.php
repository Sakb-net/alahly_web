<div class="panel-body">
    <div class="ool-sm-12">
        <label> الفريق الاول:</label>
    </div>
    <div class="raw first-repeater">
        <div  data-repeater-list="first" >
            @if(count($all_first)!=0)
            @foreach ($all_first as $key => $first)
            <div  data-repeater-item>
                <div class="col-sm-11">
                    <div class="row">
                        <div class="col-sm-12 col-md-9 col-lg-9 ">
                            <label> اسم الاعب:</label>
                            {!! Form::text('name_player', $first['name_player'], array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3 ">
                            <label> دقيقة الهدف:</label>
                            {!! Form::number('time_player', $first['time_player'], array('class' => 'form-control')) !!}
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
        <input  type="button" class="btn btn-success btn-s-xs first-add-show" value="اضافة  "/>
    </div>
    <div class="clearfix"></div>
    <div class="raw first-add-repeater hide">
        <div  data-repeater-list="first_add" >
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