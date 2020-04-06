<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <!--- latest news -->
                <div class="News">
                    <h3 class="block-title">
                        <span>أحدث الأخبار</span>
                        <a class="read-more" href="{{ route('news.index') }}">المزيد ...</a>
                    </h3>
                    <div class="row">
                       @foreach($news as $keynews=>$val_news)
                       @if($keynews==0)
                        <div class="col-md-6">
                            <div class="post-block-style latest-img clearfix">
                                <div class="post-thumb">
                                    <a href="{{ route('news.single',$val_news->link) }}">
                                         @if(!empty($val_news->image))
                                        <img class="img-fluid" src="{{ $val_news->image }}" alt="">
                                        @else
                                        <img class="img-fluid" src="{{ asset('images/news-img/sport.jpg') }}" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="post-content">
                                    <h2 class="post-title">
                                        <a href="{{ route('news.single',$val_news->link) }}">{{$val_news->name}}</a>
                                    </h2>
                                    <div class="post-meta">
                                        <span class="post-date">{{arabic_date_number($val_news->created_at->format('Y-m-d'),'-')}}</span>
                                    </div>
                                    <p>{{str_limit($val_news->content, $limit = 100, $end = '...')}}</p>
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
                                                <a href="{{ route('news.single',$val_news->link) }}">
                                                    @if(!empty($val_news->image))
                                                    <img class="img-fluid" src="{{ $val_news->image }}" alt="">
                                                    @else
                                                    <img class="img-fluid" src="{{ asset('images/news-img/sport.jpg') }}" alt="">
                                                    @endif
                                                </a>
                                            </div>
                                            <!-- Post thumb end -->
                                            <div class="post-content">
                                                <h2 class="post-title title-small">
                                                    <a href="{{ route('news.single',$val_news->link) }}">{{$val_news->name}}</a>
                                                </h2>
                                                <div class="post-meta">
                                                    <span class="post-date">{{arabic_date_number($val_news->created_at->format('Y-m-d'),'-')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Post block style end -->
                                    </li>
                                    @endif
                                @if($keynews==$count__news_1) 
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
            <!-- sidebar -->
        @include('site.layouts.sidebar')
        </div>
    </div>
</section>