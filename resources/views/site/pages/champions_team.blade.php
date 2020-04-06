<select class="form-control select_subteam_sport" id="select_subteam_sport">
    @if(count($subteams)<=0)
        <option value="0">اختر الرياضة</option>
    @else
        <option value="0">اختر الفريق</option>
        @foreach($subteams as $key_sub_team=>$val_sub_team)
            <option value="{{$val_sub_team['link']}}">{{$val_sub_team['name']}}</option>
        @endforeach
    @endif
</select>