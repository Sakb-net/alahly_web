<div class="draw_get_subteam" id="draw_get_subteam">
    @if(count($subteams)!=0)
    <div class="form-group">
        <label> القسم الفرعى </label>
            {!! Form::select('parent_id',$subteams ,$cat_subteams, array('class' => 'select2 select','required'=>'')) !!}
    </div>

    @endif
</div>
