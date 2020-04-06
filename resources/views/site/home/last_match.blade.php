<section class="latest-match section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="fixture_detail clearfix ">
                <div class="section-title">
                    <h2>المباراة السابقة</h2>
                </div>
                <h3>{{$match_perv['name']}}</h3>
                <div class="command_left ">
                    <div class="command_info">
                        <div class="logo">
                            <img src="{{$match_perv['first_image']}}">
                        </div>
                        <div class="score heading-font">{{$match_perv['first_goal']}}</div>
                    </div>
                    <div class="goals">
                        <h2>{{$match_perv['first_team']}}</h2>
                    </div>
                </div>
                <div class="command_right ">
                    <div class="command_info">
                        <div class="logo">
                            <img src="{{$match_perv['second_image']}}">
                        </div>
                        <div class="score heading-font">{{$match_perv['second_goal']}}</div>
                    </div>
                    <div class="goals">
                        <h2>{{$match_perv['second_team']}}</h2>
                    </div>
                </div>
                <div class="clearfix">
                    <a class="butn butn-bg margin-top" href="{{ route('matches.match.single',$match_perv['link']) }}"><span>تفاصيل المباراة</span></a>
                </div>
            </div>
        </div>
    </div>
</section>