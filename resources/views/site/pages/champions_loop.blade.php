@if(count($data)>0)
@foreach($data as $key_data=>$val_data)
<div class="col-md-3 col-sm-6 col-xs-6 wow fadeInUp">
    <div class="our-team">
        <img src="{{$val_data->icon_image}}" alt="">
        <div class="person-details">
            <h3 class="person-name">{{$val_data->name}}</h3>
        </div>
    </div>
</div>
@endforeach
@else
<div class="row">
    <div class="col-md-12 col-xs-12 no-courses-found">
        <div class="alert alert-info alert-dismissible" role="alert" style="color:#000;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span class="icon icon-info"></span>{{trans('app.not_found_champion')}}  {{trans('app.mark_quest')}} 
        </div>
    </div>
</div>
@endif