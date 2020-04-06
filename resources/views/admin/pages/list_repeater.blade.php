<div class="box">
    <div class="box-body">
        <label>قائمة العناصر: </label>
        <div class="clearfix m-b"></div>
        <div class="raw title-repeater">
            <div  data-repeater-list="titleHome" >
                @if(count($all_title)!=0)
                @foreach ($all_title as $key => $title)
                <div  data-repeater-item>
                    <div class="col-sm-10">    
                       {!! Form::text('name', $title, array('class' => 'form-control')) !!}
                        <div class="clearfix m-b"></div> <hr/>
                    </div>
                    <div class="col-sm-1 bi-input">
                        <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                    </div> 
                </div> 
                @endforeach
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3 col-sm-4">
            <input  type="button" class="btn btn-success btn-s-xs title-add-show" value="اضافة  عنصر"/>
        </div>
        <div class="clearfix"></div>
        <div class="raw title-add-repeater hide">
            <div  data-repeater-list="title_addHome" >
                <div  data-repeater-item>
                    <div class="col-sm-10"> 
                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-sm-1 bi-input">
                        <input data-repeater-delete type="button" class="btn btn-danger fa fa-remove" value="&#xf00d"/>
                    </div> 
                    <div class="clearfix m-b"></div> <hr/>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 m-b">
                <input data-repeater-create type="button" class="btn btn-success btn-s-xs" value="اضافة  عنصر"/>
            </div>
        </div>
    </div>
</div>