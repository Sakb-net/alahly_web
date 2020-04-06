<div class="ratting-form-wrapper pl-50">
    <h3>اترك تعليقا</h3>
    <div class="ratting-form">
        <form role="form" data-validate="parsley"  action=""  method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="parent_two_id"  class="form-control parent_two_id" id="parent_two_id"/>
            <div class="star-box">
                <span>تقييمك:</span>
                <div class="ratting-star">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <input type="number" name="user_ratting" class="form-control  user_ratting" id="user_ratting" min="0" max="5" />
            </div>
            <div class="row">
                @guest
                <div class="col-md-12">
                    <div class="form-group">
                        <input class="form-control user_name" id="user_name" name="user_name" placeholder="{{trans('app.name')}} ..." type="text" required="">
                        <div class="clearfix"></div>
                        <p class="alert alert-danger raduis comment_error_user hide" ></p>
                    </div>
                </div>
                <!-- Col end -->
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="user_email" class="form-control  user_email" id="user_email"  required placeholder="{{trans('app.enter_your_email')}}" />
                        <div class="clearfix"></div>
                        <p class="alert alert-danger raduis comment_error_email hide" ></p>
                    </div>
                </div>
                @else
                <input name="user_name" value="user_name" data-required="true" class="form-control mb-10 user_name" id="user_name" type="hidden">
                <input name="user_email" value="user@gmail.com" data-type="email" data-required="true" class="s_mail form-control mb-10 user_email" id="user_email" type="hidden">
                @endguest
                <div class="col-md-12">
                    <div class="rating-form-style form-submit">
                        <textarea class="form-control required-field user_message" name="user_message" id="user_message" placeholder="التعليق" rows="10" required=""></textarea>
                        <div class="clearfix"></div>
                        <p class="alert alert-danger raduis comment_error_content hide" ></p>
                        <div class="clearfix"></div>
                        <input class="butn butn-bg add_post_user_message"  data-link='{{$data['link']}}' id="add_post_user_message" type="submit" data-type="{{$type}}" value="إرسال التعليق">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>