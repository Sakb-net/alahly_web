<thead>
    <tr>

        <th>ID</th>

        <th>الاسم</th>

        <th>الاسم الظاهر</th>

        <th>الوصف</th>

        <th>الاعدادات</th>

    </tr>
</thead>

@foreach ($data as $key => $permission)

<tr>

    <td>{{ $permission->id }}</td>

    <td>{{ $permission->name }}</td>

    <td>{{ $permission->display_name }}</td>
    
    <td>{{ $permission->description }}</td>

    <td>
        @if($permission_edit == 1)
        <!--<a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.permission.show',$permission->id) }}"></a>-->

        <a class="btn btn-primary fa fa-edit" href="{{ route('admin.permission.edit',$permission->id) }}"></a>
        @endif
        
        @if($permission_delete == 1)

        <a id="delete" data-name="{{ $permission->name }}" data-id='{{ $permission->id }}' class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.permission.destroy', $permission->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $permission->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>

</tr>

@endforeach

