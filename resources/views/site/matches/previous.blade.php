@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                @foreach($data as $keypost=>$val_data)
                <div class="col-md-6 wow fadeInUp">
                    <div class="match">
                        <h3>{{$val_data->name}}</h3>
                        <ul class="match-vs">
                            <li><img src="{{$val_data->first_image}}" alt="{{$val_data->first_team}}"><span>{{$val_data->first_team}}</span></li>
                            <li class="result">{{$val_data->first_goal}}</li>
                            <li class="vs">
                                <h4 class="yellow">VS</h4>
                            </li>
                            <li class="result">{{$val_data->second_goal}}</li>
                            <li><img src="{{$val_data->second_image}}" alt="{{$val_data->second_team}}"><span>{{$val_data->second_team}}</span></li>
                        </ul>
                        <?php $date_time= App\Model\Match::get_DateTime($val_data->date, $val_data->time); ?>
                        <p>{{$date_time['date']}} {{$date_time['time']}}</p>
                        <a href="{{ route('matches.match.single',$val_data->link) }}" class="butn butn-bg"><span>تفاصيل المباراة</span></a>
                    </div>
                </div>
                @endforeach
               <!-- pagination -->
                <div class="row">
                    <div class="styled-pagination col-md-12">
                        <div class="clearfix"></div>
                        <div class="see-more ">
                            {!! $data->render() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- sidebar -->
        @include('site.layouts.sidebar')
        </div>
    </div>
</section>
@endsection
