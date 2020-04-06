@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- search form -->
            <div class="col-md-8 col-md-offset-2 text-center">
                <form class="form-inline" action="#">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label>الرياضة:</label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control select_sport" id="select_sport">
                                <option value="0">اختر الرياضة</option>
                                @foreach($teams as $key_team=>$val_team)
                                <option value="{{$val_team['link']}}">{{$val_team['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label>الفريق:</label>
                        </div>
                        <div class="col-md-9 draw_select_subteam" id="draw_select_subteam">
                            @include('site.pages.champions_team')
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <input type="submit" value="بحث" class="add-to-cart-btn search_champions" id="search_champions">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row draw_data_champions" id="draw_data_champions">
            @include('site.pages.champions_loop')
        </div>
        <!-- pagination -->
        <!--        <div class="row">
                    <div class="styled-pagination col-md-12">
                        <ul class="clearfix">
                            <li><a class="prev" href="#"><i class="fa fa-angle-double-right"></i></a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#" class="active">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a class="next" href="#"><i class="fa fa-angle-double-left"></i></a></li>
                        </ul>
                    </div>
                </div>-->
    </div>
</section>
@endsection
