@for($i=100; $i >0; $i--) 
    @if(isset($posts[$i]['row'])&&$posts[$i]['row']==$i)
    @if(in_array($posts[$i]['id'],$current_order_active))
        <a href="#" class="a_not_active" style="pointer-events: none;"><div style="background-color: #a8abaf;" class="circle "></div><a>
    @elseif(in_array($posts[$i]['id'],$chairs_order_active))
        <a href="#" class="a_not_active" style="pointer-events: none;"><div class="circle "></div><a>
    @else
        <a class="tzaker_chair" data-link="{{$posts[$i]['link']}}" data-name="{{$posts[$i]['name']}}">
            <div class="circle @if(in_array($posts[$i]['id'],$chairs_cart)) cir_cart @else cir_{{$posts[$i]['link']}} active @endif " title="سعر التذكرة :{!!conditionPrice(round($posts[$i]['price'] - (($posts[$i]['price'] * $posts[$i]['discount']) / 100), 2))!!} ريال" data-toggle="tooltip">
            </div>
        <a>
    @endif        
    @else
        <a href="#" style="pointer-events: none;">
            <div class="circle circle_empty"></div>
        <a>
    @endif
@endfor