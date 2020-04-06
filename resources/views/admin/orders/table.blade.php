<thead>
    <tr>
        <th>ID</th>
        <th>ID- Chart</th>
        <th>{{trans('app.chart')}} </th>
        <th>{{trans('app.member')}} </th>
        <th>{{trans('app.state')}} </th>
        <th>{{trans('app.view')}} </th>
        @if($order_edit == 1  || $order_show == 1  || $order_delete == 1)
        <th style="width: 350px;">{{trans('app.settings')}} </th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $order)
<tr>
    <td>{{ $order->id }}</td>
    <td>{{ $order->post_id }}</td>
    <td>{{ $order->name }}</td>
    <td>{!! str_replace('@', '@ ', $order->user->email) !!}</td>
    <td>
    @if($order->is_active == 0)
        <a class="orderstatus fa fa-remove btn  btn-danger btn-state"  data-id='{{ $order->id }}' data-status='1' ></a>
    @else
        <a class="orderstatus fa fa-check btn  btn-success btn-state"  data-id='{{ $order->id }}' data-status='0' ></a>
    @endif
    </td>
    <td>
    @if($order->is_read == 0)
        <a class="orderstatus fa fa-eye-slash btn  btn-danger btn-state"  data-id='{{ $order->id }}' data-status='1' ></a>
    @else
        <a class="orderstatus fa fa-eye btn  btn-success btn-state"  data-id='{{ $order->id }}' data-status='0' ></a>
    @endif
    </td>
    @if($order_edit == 1  || $order_show == 1  || $order_delete == 1 || $comment_list == 1 || $comment_create == 1)
    <td>
<!--            @if($order_show == 1)
                <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.orders.show',$order->id) }}"></a>
            @endif-->
            @if($order_edit == 1)
                <!--<a class="btn btn-primary fa fa-edit btn-order" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.update')}}  " href="{{ route('admin.orders.edit',$order->id) }}"></a>-->
            @endif
            @if($order_delete == 1)
            <a id="delete" data-id='{{ $order->id }}' data-name='{{ $order->name }}' data-toggle="tooltip" data-placement="top" data-title="{{trans('app.delete')}}  {{trans('app.share')}} " class="btn btn-danger fa fa-trash btn-order"></a>
            {!! Form::open(['method' => 'DELETE','route' => ['admin.orders.destroy', $order->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $order->id]) !!}
            {!! Form::close() !!}
            @endif
    </td>
    @endif
</tr>
@endforeach