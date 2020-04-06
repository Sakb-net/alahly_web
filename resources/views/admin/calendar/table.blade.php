<thead>
    <tr>
        <th>ID</th>
        <th>المناسبة</th>
        <th>تاريخ المناسبة</th>
        <!--<th>ملاحظة</th>-->
        @if($calendar_edit == 1)
        <th>الحالة</th>
        @endif
        @if($calendar_edit == 1  || $calendar_show == 1 || $calendar_delete == 1 )
        <th>الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $calendar)
<tr>
    <td>{{ $calendar->id }}</td>
    <td>{{ $calendar->name }}</td>
    <td>{{ $calendar->date }}</td>
<!--<td>{{str_limit($calendar->content, $limit = 80, $end = '...')}}</td>-->
    @if($calendar_edit == 1)
    <td>
        @if($calendar->is_active == 0)
        <a class="calendarstatus fa fa-remove btn  btn-danger"  data-id='{{ $calendar->id }}' data-status='1' ></a>
        @else
        <a class="calendarstatus fa fa-check btn  btn-success"  data-id='{{ $calendar->id }}' data-status='0' ></a>
        @endif
    </td>
    @endif
    @if($calendar_edit == 1  || $calendar_show == 1 || $calendar_delete == 1)
    <td>
        <!--if  $calendar_show == 1-->
        @if($calendar->type=="calendar")
        <!--fa-eye-slash-->
        <!--<a class="btn btn-info fa fa-cube"  data-toggle="tooltip" data-placement="top" data-title="عرض  مجلس الجمهور" href="{{ route('admin.calendar.show',$calendar->id) }}"></a>-->
        @endif
        @if($calendar_edit == 1)
        <a class="btn btn-primary fa fa-edit"  data-toggle="tooltip" data-placement="top" data-title=" تعديل" href="{{ route('admin.calendar.edit',$calendar->id) }}"></a>
        @endif
        @if($calendar_delete == 1)
        <a id="delete" data-id='{{ $calendar->id }}' data-name='{{ $calendar->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف الروزنامة  " class="btn btn-danger fa fa-trash"></a>
        {!! Form::open(['method' => 'DELETE','route' => ['admin.calendar.destroy', $calendar->id],'style'=>'display:inline']) !!}
        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $calendar->id]) !!}
        {!! Form::close() !!}
        @endif
    </td>
    @endif
</tr>
@endforeach