<thead>
    <tr>

        <th>ID</th>

        <th>الاسم</th>

        <th>التكلف</th>
        <th>نوع التكلفة</th>
        <!--<th>المحتوى</th>-->
        @if($fees_edit == 1)
        <th>الحالة</th>
        @endif
        @if($fees_edit == 1  || $fees_show == 1 || $fees_delete == 1 )
        <th>الاعدادات</th>
        @endif
    </tr>
</thead>

@foreach ($data as $key => $fees)
<tr>
    <td>{{ $fees->id }}</td>
    <td>{{ $fees->name }}</td>
    <td>{{ $fees->price }}</td>
    <td>{!!FeesTypePriceData($fees->type_price)!!}</td>

<!--<td>{{str_limit($fees->content, $limit = 80, $end = '...')}}</td>-->
    @if($fees_edit == 1)
    <td>
        @if($fees->is_active == 0)
        <a class="feesstatus fa fa-remove btn  btn-danger"  data-id='{{ $fees->id }}' data-status='1' ></a>
        @else
        <a class="feesstatus fa fa-check btn  btn-success"  data-id='{{ $fees->id }}' data-status='0' ></a>
        @endif

    </td>
    @endif
    @if($fees_edit == 1  || $fees_show == 1 || $fees_delete == 1)
    <td>
        @if($fees_edit == 1)
        <a class="btn btn-primary fa fa-edit"  data-toggle="tooltip" data-placement="top" data-title=" تعديل" href="{{ route('admin.fees.edit',$fees->id) }}"></a>
        @endif
        @if($fees_delete == 1 && $fees->id !=1&& $fees->id !=2&& $fees->id !=3)
        <a id="delete" data-id='{{ $fees->id }}' data-name='{{ $fees->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف الرسوم" class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.fees.destroy', $fees->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $fees->id]) !!}

        {!! Form::close() !!}

        @endif

    </td>
    @endif
</tr>

@endforeach

