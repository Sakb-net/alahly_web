@extends('site.layouts.app')
@section('content')
@include('site.layouts.page_title')
<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h2>{{$data->name}}</h2>
                <div class="choices">
                    <form action="#">
                        @foreach($anwsers as $key_ans=>$val_ans)
                        <div class="choice wow fadeInUp">
                            <div class="poll-option">
                                <input type="radio" id="{{++$key_ans}}" name="player">
                                <label for="{{++$key_ans}}">{{$val_ans['name']}}</label>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$val_ans['rate']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$val_ans['rate']}}%;">
                                    {{$val_ans['rate']}}%
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center">
                            <input type="submit" value="تصويت" class="add-to-cart-btn margin-top">
                        </div>
                    </form>
                </div>
            </div>
            <!-- sidebar -->
        @include('site.layouts.sidebar')
        </div>
    </div>
</section>
@endsection