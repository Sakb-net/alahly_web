@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <div class="fixture_detail clearfix ">
            <h3>{{$data->name}}</h3>
            <?php $date_time = App\Model\Match::get_DateTimeReult($data->result,$data->video_id, $data->date, $data->time); ?>
            <div class="command_left ">
                <div class="command_info">
                    <div class="logo">
                        <img src="{{$data->first_image}}">
                    </div>
                    <div class="score heading-font">{{$data->first_goal}}</div>
                </div>
                <div class="goals">
                    <h2>{{$data->first_team}}</h2>
                    <ul class="players">
                        @foreach ($date_time['data_first'] as $key_first => $first)
                        <li>{{$first['name_player']}}<span>'{{$first['time_player']}}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="command_right ">
                <div class="command_info">
                    <div class="logo">
                        <img src="{{$data->second_image}}">
                    </div>
                    <div class="score heading-font">{{$data->second_goal}}</div>
                </div>
                <div class="goals">
                    <h2>{{$data->second_team}}</h2>
                    <ul class="players">
                        @foreach ($date_time['data_second'] as $key_second => $second)
                        <li>{{$second['name_player']}}<span>'{{$second['time_player']}}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="clearfix">
                <h3>{{$date_time['date']}} , {{$date_time['time']}}</h3>
                <h3>انتهت المباراة</h3>
            </div>
        </div>
    </div>
    <!-- /.opacity -->
</div>
<!-- 
    =============================================
        Matches
    ============================================== 
-->
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <!--Tab Menu Start -->
            <div class="col-md-12">
                <div class="nav" role="tablist">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link" data-toggle="tab" href="#video" role="tab">
                                <i class="fa fa-play"></i>فيديو المباراة
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#info" role="tab">
                                <i class="fa fa-info-circle"></i>إحصائيات المباراة
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#summary" role="tab">
                                <i class="fa fa-futbol-o"></i>ملخص المباراة 
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Tab Content Start -->
                <div class="tab-content" id="myTabContent">
                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade active in" id="video" role="tabpanel">
                        <div class="mytab-content">
                        @if($date_time['upload']==1)
                            <iframe width="100%" height="500" src="{{$date_time['video']}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                        <object width="100%" height="500" type="application/x-shockwave-flash" @if(isset($date_time['video']))  data="{{$date_time['video']}}" @else style="display:none;" @endif>
                                <param name="src" id="myVideo" @if(isset($date_time['video'])) value="{{$date_time['video']}}" @else style="display:none;" @endif />
                        </object>
                        @endif
                        </div>
                    </div>
                    <!-- Single Tab Content End -->

                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade" id="info" role="tabpanel">
                        <div class="mytab-content">
                            <table class="table table-striped">
                                <tbody class="text-center">
                                    <tr>
                                        <th></th>
                                        <th>{{$data->first_team}}</th>
                                        <th>{{$data->second_team}}</th>
                                    </tr>
                                    <tr>
                                        <th>الأهداف</th>
                                        <td>{{$data->first_goal}}</td>
                                        <td>{{$data->second_goal}}</td>
                                    </tr>
                                    <tr>
                                        <th>الضربات الركنية</th>
                                        <td>{{$date_time['strikes1']}}</td>
                                        <td>{{$date_time['strikes2']}}</td>
                                    </tr>
                                    <tr>
                                        <th>التسلل</th>
                                        <td>{{$date_time['offside1']}}</td>
                                        <td>{{$date_time['offside2']}}</td>
                                    </tr>
                                    <tr>
                                        <th>الكروت الصفراء</th>
                                        <td>{{$date_time['cart_yellow1']}}</td>
                                        <td>{{$date_time['cart_yellow2']}}</td>
                                    </tr>
                                    <tr>
                                        <th>الكروت الحمراء</th>
                                        <td>{{$date_time['cart_red1']}}</td>
                                        <td>{{$date_time['cart_red2']}}</td>
                                    </tr>
                                    <tr>
                                        <th>التسديد على المرمى</th>
                                        <td>{{$date_time['paying_goal1']}}</td>
                                        <td>{{$date_time['paying_goal2']}}</td>
                                    </tr>
                                    <tr>
                                        <th>التمريرات</th>
                                        <td>{{$date_time['passes1']}}</td>
                                        <td>{{$date_time['passes2']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Single Tab Content End -->
                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade" id="summary" role="tabpanel">
                        <div class="mytab-content">{!!$data->description!!}</div>
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