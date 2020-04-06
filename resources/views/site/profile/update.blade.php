
<div class="tab-pane fade" id="account-info" role="tabpanel">
    <div class="myaccount-content">
        <!--<h3>تفاصيل الحساب</h3>-->
        <div class="account-details-form">
            {!! Form::open(array('route' => 'profile.store', 'method'=>'post','data-parsley-validate'=>"")) !!}
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <h3> {{trans('app.update')}} {{trans('app.profile')}}</h3>
                    @include('site.profile.update_profile')
                </div>
                <div class="col-md-12 col-xs-12">
                    <h3>{{trans('app.change')}} {{trans('app.password')}}</h3>
                    @include('site.profile.update_password')
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
