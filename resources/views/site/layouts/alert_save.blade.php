<div class="draw_registers" id="draw_registers">
@if(!isset($wrong_form) || empty($wrong_form))
    @php $wrong_form=Session::get('wrong_form_login') @endphp
    @php(session()->forget('wrong_form_login'))
@endif
@if(isset($wrong_form) && !empty($wrong_form))
<p class="alert alert-danger mb-30 msg_fail"><img src="{{asset('images/icon/fail.svg') }}" alt="" /> {{$wrong_form}} </p>
@endif
@if(isset($correct_form) && !empty($correct_form))
<p class="alert alert-success mb-30 ">{{$correct_form}}</p>
@endif
</div>