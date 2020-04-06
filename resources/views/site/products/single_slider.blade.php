<div class="col-md-5">
    <div class="prod-slider-wrap">
        <div class="flexslider prod-slider" id="prod-slider">
            <ul class="slides">
                <li>
                    <a data-fancybox="gallery" class="fancy-img" href="{{$data['image']}}">
                        <img src="{{$data['image']}}" alt="">
                    </a>
                </li>
                @foreach($data['another_image'] as $keyan_img=>$valan_img)
                <li>
                    <a data-fancybox="gallery" class="fancy-img" href="{{$valan_img['name']}}">
                        <img src="{{$valan_img['name']}}" alt="">
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="flexslider prod-thumbs" id="prod-thumbs">
            <ul class="slides">
                <li>
                    <img src="{{$data['image']}}" alt="">
                </li>
                @foreach($data['another_image'] as $keyan_img=>$valan_img)
                <li>
                    <img src="{{$valan_img['name']}}" alt="">
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>