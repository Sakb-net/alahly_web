<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box">
            <div class="box-body">
                {!! Form::hidden('type', 'order') !!}
                
                <div class="form-group ">
                    <label> {{trans('app.email')}} </label>
                    {!! Form::select('user_id',$users ,$orderUser, array('class' => 'select2','required'=>'')) !!}
                </div>
                <div class="form-group ">
                    <label> {{trans('app.name')}}  {{trans('app.Course')}} </label>
                    {!! Form::select('post_id[]', $courses,$orderCourse, array('class' => 'select2-tags','required'=>'','multiple')) !!}
                </div>
                <div class="form-group">
                    <label>{{trans('app.type_feat')}} {{trans('app.Course')}} :</label>
                    @if(isset($order->discount))
                        @if($order->discount== '0.00' && $order->price== '0.00')
                            {!! Form::select('type_cost',$costType_lang() ,'free', array('class' => 'select2','id'=>'type_cost')) !!}
                        @elseif($order->discount == '0.00' && $order->price != '0.00')
                            {!! Form::select('type_cost',$costType_lang() ,'premium', array('class' => 'select2','id'=>'type_cost')) !!}
                        @else
                            {!! Form::select('type_cost',$costType_lang() ,'discount', array('class' => 'select2','id'=>'type_cost')) !!}
                        @endif
                    @else
                    {!! Form::select('type_cost',$costType_lang() ,null, array('class' => 'select2','id'=>'type_cost')) !!}
                    @endif
                </div>
                @if(isset($order->discount) && $order->discount != '0.00')
                 <div class="form-group allow_discount">
                    <label>{{trans('app.discount')}}  {{trans('app.Course')}}  %:</label>
                    {!! Form::text('discount', $order->discount, array('class' => 'form-control','value'=>'0')) !!}
                 </div>
                @else
                    <div class="form-group allow_discount hide">
                    <label>{{trans('app.discount')}}  {{trans('app.Course')}}  %:</label>
                    {!! Form::text('discount', null, array('class' => 'form-control','value'=>'0')) !!}
                    </div>
                @endif
                @if($new == 0)
                <div class="form-group">
                    <label>{{trans('app.state')}}  {{trans('app.active')}} :</label>
                    {!! Form::select('is_share',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>{{trans('app.state')}}  {{trans('app.share')}} :</label>
                    {!! Form::select('is_active',statusType() ,null, array('class' => 'select2','required'=>'')) !!}
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
