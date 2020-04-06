@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <!--Tab Menu Start -->
            <div class="col-md-12">
                <div class="nav" role="tablist">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @if(count($players)>0)
                        <li class="nav-item active">
                            <a class="nav-link" data-toggle="tab" href="#players" role="tab">
                                <i class="fa fa-users"></i>قائمة اللاعبين
                            </a>
                        </li>
                        @endif
                        @if(count($coaches)>0)
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#trainers" role="tab">
                                <i class="fa fa-user"></i>قائمة المدرب ومساعديه
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- Tab Content Start -->
                <div class="tab-content" id="myTabContent">
                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade active in" id="players" role="tabpanel">
                        <div class="mytab-content">
                            <div class="row">
                                @foreach($players as $key_pay=>$val_pay)
                                <div class="col-md-3 col-sm-6 col-xs-6 wow fadeInUp">
                                    <div class="our-team">
                                        <a href="{{ route('teams.user.single',$val_pay['link']) }}">
                                            <img src="{{$val_pay['user_image']}}" alt="">
                                            <div class="person-details">
                                                <h3 class="person-name">{{$val_pay['name']}}</h3>
                                                <p class="team-position">{{$val_pay['location']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Single Tab Content End -->

                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade" id="trainers" role="tabpanel">
                        <div class="mytab-content">
                            <div class="row">
                                @foreach($coaches as $key_coach=>$val_coach)
                                <div class="col-md-3 col-sm-6 col-xs-6 wow fadeInUp">
                                    <div class="our-team">
                                        <a href="{{ route('teams.user.single',$val_coach['link']) }}">
                                            <img src="{{$val_coach['user_image']}}" alt="">
                                            <div class="person-details">
                                                <h3 class="person-name">{{$val_coach['name']}}</h3>
                                                <p class="team-position">{{$val_coach['location']}}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Single Tab Content End -->
                </div>
                <!-- Tab Content End -->
            </div>
            <!-- Tab Menu End -->
        </div>
    </div>
</section>
@endsection
