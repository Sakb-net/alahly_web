@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div id="calendar"></div>
        </div>
    </div>
</section>
@endsection
@section('after_head')
<link rel="stylesheet" type="text/css" href="{{ asset('js/site/lib/plugins/event-calendar/mini-event-calendar.css') }}">
@stop  
@section('after_foot')
<script src="{{ asset('js/site/lib/plugins/event-calendar/mini-event-calendar.js') }}"></script>
<script>
    // All dates should be provided in timestamps
    var sampleEvents = [];
    var data =  <?php echo json_encode($data); ?>;
    $.each(data, function (index, value) {
        if(value.signal=='+'){
            var date=new Date().setDate(new Date().getDate()+value.num_day);
        }else if(value.signal=='-'){
            var date=new Date().setDate(new Date().getDate()-value.num_day);
        }else{
            date=new Date().getTime();
        }
        div_section = {'title':value.name,'date': date,'link': value.url_link};
        sampleEvents.push(div_section);
    });
$(document).ready(function () {
    $("#calendar").MEC({
        events: sampleEvents
    });

});
</script>

@stop 