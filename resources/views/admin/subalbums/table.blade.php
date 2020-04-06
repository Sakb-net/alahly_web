<thead>
    <tr>

        <th>ID</th>

        <th>الاسم</th>
        
        <th>الصور</th>
        <!--<th>المحتوى</th>-->
        @if($category_edit == 1)
        <th>الحالة</th>
        @endif
        @if($category_edit == 1  || $category_show == 1 || $category_delete == 1 )
        <th>الاعدادات</th>
        @endif
    </tr>
</thead>

@foreach ($data as $key => $album)

<tr>

    <td>{{ $album->id }}</td>

    <td>{{ $album->name }}</td>
    <td><img style="width:100px" src="{{ $album->image }}"/></td>
    
    <!--<td>{{str_limit($album->content, $limit = 80, $end = '...')}}</td>-->
    @if($category_edit == 1)
    <td>
    @if($album->is_active == 0)
        <a class="categorystatus fa fa-remove btn  btn-danger"  data-id='{{ $album->id }}' data-status='1' ></a>
    @else
        <a class="categorystatus fa fa-check btn  btn-success"  data-id='{{ $album->id }}' data-status='0' ></a>
    @endif
        
    </td>
    @endif
    @if($category_edit == 1  || $category_show == 1 || $category_delete == 1)
    <td>
<!--        @if($category_show == 1)
        <a class="btn btn-info fa fa-eye-slash"  data-toggle="tooltip" data-placement="top" data-title="عرض  الصورة" href="{{ route('admin.subalbums.show',$album->id) }}"></a>
        @endif-->
        @if($category_edit == 1)
        <a class="btn btn-primary fa fa-edit" data-toggle="tooltip" data-placement="top" data-title="تعديل  صورة الالبوم"  href="{{ route('admin.subalbums.edit',$album->id) }}"></a>
        @endif
        @if($category_delete == 1)

        <a id="delete" data-id='{{ $album->id }}' data-name='{{ $album->name }}'  data-toggle="tooltip" data-placement="top" data-title="حذف  الصورة" class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.subalbums.destroy', $album->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $album->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>
    @endif
</tr>

@endforeach

