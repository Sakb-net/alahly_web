<section class="section-padding wow fadeInUp">
    <div class="container">
        <div class="row">
            <h3 class="block-title">
                <span>معرض الصور</span>
                <a class="read-more" href="{{ route('gallery.index') }}">المزيد ...</a>
            </h3>
            <div class="row">
                @foreach($gallery as $keygallery=>$val_gallery)
                <div class="col-md-4 col-sm-6">
                    <div class="post-block-style clearfix">
                        <div class="post-thumb">
                            <a href="{{ route('gallery.single',$val_gallery->link) }}">
                                @if(!empty($val_gallery->image))
                                <img class="img-fluid" src="{{ $val_gallery->image }}" alt="">
                                @else
                                <img class="img-fluid" src="{{ asset('images/news-img/sport.jpg') }}" alt="">
                                @endif
                                <div class="video-icon"><i class="fa fa-link"></i></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <h2 class="post-title">
                                <a href="{{ route('gallery.single',$val_gallery->link) }}">{{$val_gallery->name}}</a>
                            </h2>
                        </div>
                    </div>
                    <!-- Post Block style end -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>