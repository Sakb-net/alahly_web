@extends('site.layouts.app')
@section('content')

<div class="myinner-banner">
    <div class="opacity">
        <ul>
            <li><a href="{{ route('home') }}">الرئيسية</a></li>
            <li>/</li>
            <li><a href="{{ route('teams.teams.team.single',[$catgeory->link,$data['link']]) }}">صفحة الفريق</a></li>
        </ul>
        <h2>{{$data['name']}}</h2>
    </div>
</div>
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="featured-content-thumb">
                    <img src="{{$data['user_image']}}" class="img-fluid" alt="player">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="featured-content">
                    <div class="section-title">
                        <h2>{{$data['name']}}</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td class="bold">الرياضة:</td>
                                    <td colspan="2">{{$data['sport']}}</td>
                                </tr>
                                <tr>
                                    <td class="bold">الرقم:</td>
                                    <td colspan="2">{{$data['num_sport']}}</td>
                                </tr>
                                <tr>
                                    <td class="bold">الطول:</td>
                                    <td colspan="2">{{$data['height']}}</td>
                                </tr>
                                <tr>
                                    <td class="bold">الوزن:</td>
                                    <td colspan="2">{{$data['weight']}}</td>
                                </tr>
                                <tr>
                                    <td class="bold">المركز:</td>
                                    <td colspan="2">{{$data['location']}}</td>
                                    <!--<td class="bold">يلعب بالقدم اليمنى</td>-->
                                </tr>
                                <tr>
                                    <td class="bold">العمر:</td>
                                    <td>{{$data['age']}}</td>
                                    <td><strong>تاريخ الميلاد: </strong>{{$data['birthdate']}}</td>
                                </tr>
                                <tr>
                                    <td class="bold">الجنسية:</td>
                                    <td colspan="2"> {{$data['national']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="share">
                    <h3>المشاركة الاجتماعية:</h3>
                    <div class="social-sharer">
                        @include('site.layouts.social_icon_green')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
