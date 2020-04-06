<thead>
    <tr>

        <th>ID</th>

        <th>الرسالة باللغة العربية</th>
        
        <th>الرسالة باللغة الانجليزيه</th>
      
        @if($apimessages_edit == 1  || $apimessages_show == 1 || $apimessages_delete == 1 )
        <th>الاعدادات</th>
        @endif
    </tr>
</thead>

@foreach ($data as $key => $apimessages)
<tr>
    <td>{{ $apimessages->id }}</td>
    <td>{{ $apimessages->ar_message }}</td>
    <td>{{ $apimessages->en_message }}</td>
   
    @if($apimessages_edit == 1  || $apimessages_show == 1 || $apimessages_delete == 1)
    <td>
        @if($apimessages_edit == 1)
        <a class="btn btn-primary fa fa-edit"  data-toggle="tooltip" data-placement="top" data-title=" تعديل" href="{{ route('admin.apimessages.edit',$apimessages->id) }}"></a>
        @endif
        @if($apimessages_delete == 1 &&$apimessages->id !=1)
<!--        <a id="delete" data-id='{{ $apimessages->id }}' data-name='{{ $apimessages->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف رسائل الموقع والموبايل" class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.apimessages.destroy', $apimessages->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $apimessages->id]) !!}

        {!! Form::close() !!}-->

        @endif
        
    </td>
    @endif
</tr>

@endforeach

