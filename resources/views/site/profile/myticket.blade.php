<div class="tab-pane fade" id="orders" role="tabpanel">
    @include('site.profile.mycart')
    <div class="myaccount-content">
        <h3>تذاكري</h3>

        <div class="myaccount-table table-responsive text-center">
            <table class="table table-bordered">
                @include('site.profile.header_cart')
                <tbody>
                    @if(count($orders)>0)
                        @foreach($orders as $key_order=>$val_order)
                        <tr>
                            <td>{{$val_order->transactionId}}</td>
                            <td>{{$val_order->match->name}}</td>
                            <td>
                                <ul dir="ltr">
                                    <li>{{$val_order->name}} </li>
                                    <!--<li>تذكرة  x 2</li>-->
                                </ul>
                            </td>
                            <td>{!!getNum_rowChart($val_order->posts->row)!!}</td>
                            <td>{{$val_order->created_at->format('Y-m-d')}}</td>
                            <td>{{$val_order->price}} ريال</td>
                            <td><i class="fa fa-check-circle  icon_ok" aria-hidden="true"></i></td>
                        </tr>
                        @endforeach
                    @else
                        @include('site.profile.body_empty')
                   @endif
                </tbody>
            </table>
            <div class="see-more ">
                {!! $orders->render() !!}
            </div>

        </div>
    </div>
</div>