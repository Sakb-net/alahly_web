<div class="row">
    <div class="col-sm-9 col-xs-9 col-lg-9">
        <div class="box">
            <div class="box-body">

                <div class="form-group">

                    <label>{{trans('app.name')}} :</label>

                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required'=>'','data-parsley-type'=>'alphanum')) !!}
                </div>

                <div class="form-group">

                    <label>{{trans('app.name')}}  {{trans('app.display')}} :</label>

                    {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control','required'=>'')) !!}
                </div>
                
                <div class="form-group">

                    <label>{{trans('app.detail_desc')}} :</label>

                    {!! Form::text('description', null, array('placeholder' => 'description','class' => 'form-control')) !!}

                </div>

                @if(Auth::user()->can('access-all'))
                <div class="form-group">

                    <label>{{trans('app.roles')}} :</label>

                    {!! Form::select('permission[]', $permission,$rolePermissions, array('class' => 'select2','multiple')) !!}

                </div>
                @endif
                
                <div class="box-footer text-center">
                      <button type="submit" class="btn btn-info padding-40" >{{trans('app.save')}} </button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">{{trans('app.back')}} </a>
                </div>
            </div>
        </div>
    </div>
</div>

