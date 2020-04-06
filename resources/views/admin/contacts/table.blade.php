<thead>
    <tr>
        <th>ID</th>
        <th>ip</th>
        <th>الاسم</th>
        @if($type!='visitor')
        <th>البريد الالكترونى</th>
        @endif
        <th>الرسالة</th>
        @if($contact_active == 1 )
        <th>القراءة</th>
        <!--<th>تم الرد</th>-->
        @endif
        @if($contact_edit == 1 || $contact_delete == 1)
        <th>الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $contact)
<tr>
    <td>{{ ++$key }}</td>
    <td>{{ $contact->visitor }}</td>
    <td>{{ $contact->name }} </td>
    @if($contact->type!='visitor')
    <td>{{ $contact->email }}</td>
    @endif
    <td>{{ str_limit($contact->content, 50)  }}</td>
    @if($contact_active == 1 )
    <td>
        @if($contact->is_read == 0)
        <a class="contactread fa fa-remove btn  btn-danger"  data-id='{{ $contact->id }}' ></a>
        @else
        <a class="fa fa-check btn  btn-success"  data-id='{{ $contact->id }}' ></a>
        @endif
    </td>
<!--    <td>
            @if($contact->is_reply == 0)
                <a class="contactreply fa fa-remove btn  btn-danger"  data-id='{{ $contact->id }}' ></a>
            @else
                <a class="fa fa-check btn  btn-success"  data-id='{{ $contact->id }}' ></a>
            @endif
    </td>-->
    @endif
    @if($contact_edit == 1  || $contact_delete == 1)
    <td>
        @if($contact_edit == 1)
        <a class="btn btn-primary fa fa-eye-slash" href="{{ route('admin.contacts.show',$contact->id) }}"></a>
        <!--<a class="btn btn-primary fa fa-edit" href="{{ route('admin.contacts.edit',$contact->id) }}"></a>-->
        @endif
        @if($contact_delete == 1)
        <a id="delete" data-id='{{ $contact->id }}' data-name='{{ $contact->name }}' class="btn btn-danger fa fa-trash"></a>
        {!! Form::open(['method' => 'DELETE','route' => ['admin.contacts.destroy', $contact->id],'style'=>'display:inline']) !!}
        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $contact->id]) !!}
        {!! Form::close() !!}
        @endif
    </td>
    @endif
</tr>
@endforeach