<div class="draw_correct_wrong" id="draw_correct_wrong">
@if(isset($correct)&&!empty($correct))
<div class="col-md-12"> 
    <p class="alert alert-success mb-30 raduis" >{{$correct}}</p>
</div>
@endif
@if(isset($wrong)&&!empty($wrong))
<div class="col-md-12"> 
    <p class="alert alert-danger mb-30 raduis" >{{$wrong}}</p>
</div>
@endif
</div>