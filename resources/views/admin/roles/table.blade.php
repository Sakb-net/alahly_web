<thead>
    <tr>

        <th>ID</th>

        <th>{{trans('app.name')}} </th>

        <th>{{trans('app.name')}}  {{trans('app.display')}} </th>

        <th>{{trans('app.detail_desc')}} </th>

        <th>{{trans('app.permission')}} </th>
        
        <th>{{trans('app.settings')}} </th>

    </tr>
</thead>

@foreach ($data as $key => $role)

<tr>

    <td>{{ $role->id }}</td>

    <td>{{ $role->name }}</td>

    <td>{{ $role->display_name }}</td>
    
    <td>{{ $role->description }}</td>

    @if($role_edit == 1)
    <td>

        @if(!empty($role->permissions))

        @foreach($role->permissions as $v)

        <small class="label bg-green">{{ $v->display_name }}</small>

        @endforeach

        @endif

    </td>
    @endif
    
    <td>
        @if($role_edit == 1)
        <a class="btn btn-info fa fa-eye-slash" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.view')}}" href="{{ route('admin.roles.show',$role->id) }}"></a>

        <a class="btn btn-primary fa fa-edit" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.update')}}" href="{{ route('admin.roles.edit',$role->id) }}"></a>
        @endif
        
        @if($role_delete == 1)

        <a id="delete" data-id='{{ $role->id }}' data-toggle="tooltip" data-placement="top" data-title="{{trans('app.delete')}}" class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.roles.destroy', $role->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $role->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>

</tr>

@endforeach

