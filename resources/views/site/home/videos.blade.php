<section class="videos section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <h3 class="block-title">
                <span>أحدث الفيديوهات</span>
                <a class="read-more" href="{{ route('videos.index') }}">المزيد ...</a>
            </h3>
            <div class="row">
                @foreach($videos as $keyvideos=>$val_videos)
                @if($keyvideos==0)
                <div class="col-md-6">
                    <div class="post-block-style latest-video clearfix">
                        <div class="post-thumb">
                            <a href="{{ route('videos.single',$val_videos->link) }}">
                                @if(!empty($val_videos->image))
                                <img class="img-fluid" src="{{ $val_videos->image }}" alt="">
                                @else
                                <img class="img-fluid" src="{{ asset('images/news-img/sport.jpg') }}" alt="">
                                @endif
                                <div class="video-icon"><i class="fa fa-play"></i></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <h2 class="post-title">
                                <a href="{{ route('videos.single',$val_videos->link) }}">{{$val_videos->name}}</a>
                            </h2>
                        </div>
                    </div>
                    <!-- Post Block style end -->
                </div>
                <div class="col-md-6 pr0">
                    <div class="list-post-block" style="margin-top:0 ">
                        <ul class="list-post">
                            @else
                            <li class="clearfix">
                                <div class="post-block-style post-float clearfix">
                                    <div class="post-thumb">
                                        <a href="{{ route('videos.single',$val_videos->link) }}">
                                            @if(!empty($val_videos->image))
                                            <img class="img-fluid" src="{{ $val_videos->image }}" alt="">
                                            @else
                                            <img class="img-fluid" src="{{ asset('images/news-img/sport.jpg') }}" alt="">
                                            @endif
                                            <div class="video-icon"><i class="fa fa-play"></i></div>
                                        </a>
                                    </div>
                                    <!-- Post thumb end -->
                                    <div class="post-content">
                                        <h2 class="post-title title-small">
                                            <a href="{{ route('videos.single',$val_videos->link) }}">{{$val_videos->name}}</a>
                                        </h2>
                                    </div>
                                </div>
                                <!-- Post block style end -->
                            </li>
                            @endif
                            @if($keyvideos==$count__videos_1) 
                        </ul>
                        <!-- List post end -->
                    </div>
                    <!-- List post block end -->
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>