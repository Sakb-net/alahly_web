@inject('user', 'App\User')
<thead>
    <tr>

        <th>ID</th>

        <th>العضو</th>

        <th>الدولة</th>
        <th>المنطقة</th>
        <th>المدينة</th>
        <th>الاحداثيات</th>
        <th>الاعدادات</th>

    </tr>
</thead>

@foreach ($data as $key => $search)

<tr>

    <td>{{ $search->id }}</td>

    <td>
        @if($search->user_id > 0)
        {{ $search->name }}
        {{ $user->userID($search->user_id) }}
        @else
        زائر
        @endif
    </td>
    <td>{{ $search->country_name }}</td>
    <td>{{ $search->region_name }}</td>
    <td>{{ $search->city }}</td>
    <td>{{ $search->latitude }} , {{ $search->longitude }}</td>
    <td>
        
        @if($search_delete == 1)

        <a id="delete" data-id='{{ $search->id }}' class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.usersearches.destroy', $search->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $search->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>

</tr>

@endforeach

