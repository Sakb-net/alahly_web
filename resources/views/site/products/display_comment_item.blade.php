<div class="single-review">
    <div class="review-img">
        @if(isset($value_comment['replay_user_image'])&&!empty($value_comment['replay_user_image']))
        <img src="{{$value_comment['replay_user_image']}}" alt="user" />
        @else
        @if(!empty($value_comment['parent_user_image']))
        <img src="{{$value_comment['parent_user_image']}}" alt="user" />
        @else
        <img src="{{ asset('images/user.png') }}" alt="user" />
        @endif
        @endif
    </div>
    <div class="review-content">
        <div class="review-top-wrap">
            <div class="review-left">
                <div class="review-name">
                    @if(isset($value_comment['replay_user_name']))
                    <h4>{!!$value_comment['replay_user_name']!!}</h4>
                    @else
                    <h4>{!! $value_comment['parent_user_name']!!}</h4>
                    @endif
                </div>
                <div class="review-rating">
                    @for ($star = 1; $star <= 5; $star++)
                    @if($value_comment['star_rate'] >=$star)
                    <i class="fa fa-star"></i>
                    @else
                    <i class="fa fa-star-o"></i>
                    @endif
                    @endfor
                </div>
                <span class="comment-date">{{$value_comment['date']}}</span>
            </div>
        </div>
        <div class="review-bottom"><p>{!! $value_comment['content'] !!}</p></div>
        <div class="card-actioncomt">
            <a class="drawss_replay_comment" id="drawss_replay_comment" data-comment="{{$value_comment['link']}}"  data-toggle="tooltip" title="{{trans('app.replay')}}"><i class="fa fa-reply"></i></a>
            @if($value_comment['owner_data']=="1")
                <!--<a class="updates_questions_btn" id="updates_questions_btn" data-comment="{{$value_comment['link']}}"  data-toggle="tooltip" title="{{trans('app.update')}}"><i class="fa fa-edited"></i></a>-->
            <a class="remove_comments" id="remove_comments" data-type="{{$type}}" data-comment="{{$value_comment['link']}}"  data-toggle="tooltip" title="{{trans('app.delete')}}"><i class="fa fa-trash"></i></a>
            @endif
            <span class="count_{{$value_comment['link']}}">{{$value_comment['num_like']}}</span>
            <img class="btn-like comment_favourites img_{{$value_comment['link']}}" data-type="comment_{{$type}}" id="comment_favourites" data-link="{{$value_comment['link']}}" data-user="{{$user_key}}"  @if($value_comment['like']) src="{{ asset('images/icon/like.svg') }}" @else src="{{ asset('images/icon/like_gray.svg') }}" @endif />
                 <div class="bi-noti-like{{$value_comment['link']}}"></div>
        </div>
        <!--***********************start***********************-->
        <div class="col-lg-12">
            <div class="review-wrapper com_rp_prod @if(empty($value_comment['child_comments'])) hidden @endif">
                @foreach($value_comment['child_comments'] as $key_reply=>$val_reply)
                <div class="single-review">
                    <div class="review-img">
                        @if(isset($val_reply['replay_user_image'])&&!empty($val_reply['replay_user_image']))
                        <img src="{{$val_reply['replay_user_image']}}" alt="user" />
                        @else
                        @if(!empty($val_reply['parent_user_image']))
                        <img src="{{$val_reply['parent_user_image']}}" alt="user" />
                        @else
                        <img src="{{ asset('images/user.png') }}" alt="user" />
                        @endif
                        @endif
                    </div>
                    <div class="review-content">
                        <div class="review-top-wrap">
                            <div class="review-left">
                                <div class="review-name">
                                    @if(isset($val_reply['replay_user_name']))
                                    <h4>{!!$val_reply['replay_user_name']!!}</h4>
                                    @else
                                    <h4>{!! $val_reply['parent_user_name']!!}</h4>
                                    @endif
                                </div>
                                <div class="review-rating">
                                    @for ($star = 1; $star <= 5; $star++)
                                    @if($val_reply['star_rate'] >=$star)
                                    <i class="fa fa-star"></i>
                                    @else
                                    <i class="fa fa-star-o"></i>
                                    @endif
                                    @endfor
                                </div>
                                <span class="comment-date">{{$val_reply['date']}}</span>
                            </div>
                        </div>
                        <div class="review-bottom"><p>{!! $val_reply['content'] !!}</p></div>
                        <div class="card-actioncomt">
                            <a class="drawss_replay_comment" id="drawss_replay_comment" data-comment="{{$val_reply['link']}}"  data-toggle="tooltip" title="{{trans('app.replay')}}"><i class="fa fa-reply"></i></a>
                            @if($current_id >0 && $current_id==$val_reply['user_id'])
                                <!--<a class="updates_questions_btn" id="updates_questions_btn" data-comment="{{$val_reply['link']}}"  data-toggle="tooltip" title="{{trans('app.update')}}"><i class="fa fa-edit"></i></a>-->
                            <a class="remove_comments" id="remove_comments" data-type="{{$type}}" data-comment="{{$val_reply['link']}}"  data-toggle="tooltip" title="{{trans('app.delete')}}"><i class="fa fa-trash"></i></a>
                            @endif
                            <span class="count_{{$val_reply['link']}}">{{$val_reply['num_like']}}</span>
                            <img class="btn-like comment_favourites img_{{$val_reply['link']}}" data-type="comment_{{$type}}" id="comment_favourites" data-link="{{$val_reply['link']}}" data-user="{{$user_key}}"  @if($val_reply['like']) src="{{ asset('images/icon/like.svg') }}" @else src="{{ asset('images/icon/like_gray.svg') }}" @endif />
                                 <div class="bi-noti-like{{$val_reply['link']}}"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!--***********************end***********************-->
    </div>
</div>