<div class="col-md-3 hidden-sm hidden-xs">
    <div class="sidebar">
        @if(!isset($count__news_1))
        <div class="widget text-center">
            <img class="banner img-fluid" src="{{ asset('images/bg/banner.gif') }}" alt="">
        </div>
        <div class="widget text-center">
            <img class="banner img-fluid" src="{{ asset('images/bg/banner2.gif') }}" alt="">
        </div>
        @endif
        <div class="widget">
            <h3 class="block-title text-center">
                <span>دوري أبطال آسيا</span>
            </h3>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>الأهلي</td>
                        <td>95</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>النصر</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>الهلال</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>الفتح</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>التعاون</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>الفيصلي</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>الفيحاء</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>الاتفاق</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>الاتحاد</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>الشباب</td>
                        <td>0</td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="3">
                            <a href="{{ route('news.league') }}" class="butn butn-bg"><span>المزيد ...</span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>