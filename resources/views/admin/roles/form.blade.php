<div class="row">
    <div class="col-sm-9 col-xs-9 col-lg-9">
        <div class="box">
            <div class="box-body">

                <div class="form-group">

                    <label>الاسم:</label>

                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required'=>'','data-parsley-type'=>'alphanum')) !!}
                </div>

                <div class="form-group">

                    <label>الاسم الظاهر:</label>

                    {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control','required'=>'')) !!}
                </div>

                <div class="form-group">

                    <label>الوصف:</label>

                    {!! Form::text('description', null, array('placeholder' => 'description','class' => 'form-control')) !!}

                </div>

                @if(Auth::user()->can('access-all'))
                <div class="form-group">
                    <label>الوظائف:</label>
                    <div class="row">
                        @foreach ($permission as $key_rol => $val_rol)
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <label><input name="permission[]" type="checkbox"  id="{{$val_rol->name}}" class="custom-checkbox" value="{{$val_rol->id}}" @if($all_ok==1) checked="" @elseif(in_array($val_rol->id,$rolePermissions)) checked="" @endif>&nbsp; {{$val_rol->display_name}}</label>
                            </div>
                        </div>
                        @foreach ($val_rol->childrens as $key_child => $val_child)
                        <div class="col-sm-4 col-xs-6 col-lg-4">
                            <div class="checkbox">
                                <label><input name="permission[]" type="checkbox" class="custom-checkbox {{$val_rol->name}}" value="{{$val_child->id}}" @if($all_ok==1) checked="" @elseif(in_array($val_child->id,$rolePermissions)) checked="" @endif>&nbsp; {{$val_child->display_name}}</label>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-sm-12"><hr/></div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
</div>