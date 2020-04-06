<div class="tab-pane fade active in" id="dashboad" role="tabpanel">
    <div class="myaccount-content">
        <div class="welcome">
            @if(!empty(Auth::user()->image))
                <img class="img-thumbnail profile-img" src="{{Auth::user()->image}}">
            @else
                <img class="img-thumbnail profile-img" src="{{asset('images/user.png') }}">
            @endif
            <p>مرحبا, <strong>{{Auth::user()->display_name}}</strong></p>
        </div>
        <p>من لوحة معلومات حسابك. يمكنك بسهولة إدارة عناوين الشحن والفواتير الخاصة بك وتعديل تفاصيل الحساب.</p>
        <div class="myaccount-table table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>الاسم</th>
                        <td>{{Auth::user()->display_name}}</td>
                    </tr>
                    <tr>
                        <th>البريد الإلكتروني</th>
                        <td>{{Auth::user()->email}}</td>
                    </tr>
                    <tr>
                        <th>رقم الهاتف</th>
                        <td>{{Auth::user()->phone}}</td>
                    </tr>
<!--                    <tr>
                        <th>العنوان</th>
                        <td>مصر - القاهرة -13 شارع التحرير</td>
                    </tr>-->
                </tbody>
            </table>
        </div>

    </div>
</div>