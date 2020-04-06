<div class="col-lg-6 col-lg-offset-1">
    <div class="section-title">
        <h2>اترك رسالتك</h2>
    </div>
    @include('site.layouts.correct_wrong')
    <form class="form" id="contact-form" method="post" enctype="multipart/form-data" action="#">
        <input type="hidden" name="type_message" value="contact"  class="form-control type_message" id="type_message"/>
        <div class="controls">
            <div class="row">
                @guest
                <div class="col-md-6">
                    <div class="form-group">
                        <input id="form_name" type="text" name="user_name" class="user_name" placeholder="الاسم" required="required">
                        <div class="clearfix"></div>
                        <p class="alert alert-danger raduis comment_error_user hide" ></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input id="form_email" type="email" name="user_email" class="user_email" placeholder="البريد الإلكتروني" required="required">
                        <div class="clearfix"></div>
                        <p class="alert alert-danger raduis comment_error_email hide" ></p>
                    </div>
                </div>
                @else
                <input name="user_name" value="user_name" data-required="true" class="form-control mb-10 user_name" id="user_name" type="hidden">
                <input name="user_email" value="user@gmail.com" data-type="email" data-required="true" class="s_mail form-control mb-10 user_email" id="user_email" type="hidden">
                @endguest
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea id="form_message" name="user_message" class="user_message" placeholder="الرسالة" rows="4" required="required"></textarea>
                        <div class="clearfix"></div>
                        <p class="alert alert-danger raduis comment_error_content hide" ></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="butn butn-bg pull-right add_contact_Us" id="add_contact_Us"><span>إرسال</span></button>
                </div>
            </div>
        </div>
    </form>
</div>