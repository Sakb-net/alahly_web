<thead>
    <tr>

        <th>ID</th>

        <th>الاسم</th>
        
        <th>الاعدادات</th>

    </tr>
</thead>

@foreach ($data as $key => $tag)

<tr>

    <td>{{ $tag->id }}</td>

    <td>{{ $tag->name }}</td>
    
    <td>
        @if($tag_edit == 1)
        <a class="btn btn-info fa fa-eye-slash" data-toggle="tooltip" data-placement="top" data-title="مشاهد (tag)" href="{{ route('admin.tags.show',$tag->id) }}"></a>
        <a class="btn btn-primary fa fa-edit" data-toggle="tooltip" data-placement="top" data-title="تعديل (tag)" href="{{ route('admin.tags.edit',$tag->id) }}"></a>
        @endif
        
        @if($tag_delete == 1)

        <a id="delete" data-id='{{ $tag->id }}' data-name='{{ $tag->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف (tag)" class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.tags.destroy', $tag->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $tag->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>

</tr>

@endforeach

