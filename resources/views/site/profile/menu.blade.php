<div class="myaccount-tab-menu nav col-sm-3" role="tablist">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link" data-toggle="tab" href="#dashboad" role="tab">
                <i class="fa fa-dashboard"></i>حسابي
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#orders" role="tab">
                <i class="fa fa-cart-arrow-down"></i>تذاكري
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#account-info" role="tab">
                <i class="fa fa-user"></i>تعديل البيانات
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab"  role="tab" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                 <i class="fa fa-sign-out"></i>تسجيل الخروج
             </a>
        </li>
    </ul>
</div>