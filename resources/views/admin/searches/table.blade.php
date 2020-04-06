<thead>
    <tr>

        <th>ID</th>
        <th>الاسم</th>
        <th>عدد مرات البحث</th>
        <th>عدد مرات البحث للاعضاء</th>
        <th>عدد مرات البحث لغير المسجلين</th>
        @if($search_edit == 1)
        <th>الحالة</th>
        @endif
        <th>الاعدادات</th>

    </tr>
</thead>

@foreach ($data as $key => $search)

<tr>

    <td>{{ $search->id }}</td>

    <td>{{ $search->name }}</td>
    
    <td>{{ $search->search_count  }}</td>
    
    <td>{{ $search->login_count  }}</td>
    
    <td>{{ $search->guest_count  }}</td>
    
    @if($search_edit == 1)
    <td>
            @if($search->is_active == 0)
                <a class="searchstatus fa fa-remove btn  btn-danger"  data-id='{{ $search->id }}' data-status='1' ></a>
            @else
                <a class="searchstatus fa fa-check btn  btn-success"  data-id='{{ $search->id }}' data-status='0' ></a>
            @endif
        
    </td>
    @endif
    <td>
        @if($search_edit == 1)

        <a class="btn btn-primary fa fa-edit" href="{{ route('admin.searches.edit',$search->id) }}"></a>
        <a class="btn btn-success fa fa-eye" href="{{ route('admin.searches.show',$search->id) }}"></a>
        @endif
        
        @if($search_delete == 1)

        <a id="delete" data-id='{{ $search->id }}' class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.searches.destroy', $search->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $search->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>

</tr>

@endforeach

