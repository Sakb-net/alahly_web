<thead>
    <tr>

        <th>ID</th>

        <th>الاسم</th>
        
        <!--<th>صور</th>-->
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
    
    <!--<td><img style="width:100px" src="{{ $album->image }}"/></td>-->
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
        @if($category_edit == 1)
        <a class="btn btn-primary fa fa-edit"  data-toggle="tooltip" data-placement="top" data-title="تعديل  الالبوم" href="{{ route('admin.albums.edit',$album->id) }}"></a>
        <a class="btn btn-success fa fa-plus"  data-toggle="tooltip" data-placement="top" data-title="اضافة صورة للالبوم" href="{{ route('admin.subalbums.creat',$album->id) }}"><i class="fa fa-image"></i></a>
        @endif
        
        <!--if  $category_show == 1-->
        @if($album->type=="main")
        <!--fa-eye-slash-->
        <a class="btn btn-info fa fa-cube"  data-toggle="tooltip" data-placement="top" data-title="عرض صور الالبوم" href="{{ route('admin.albums.show',$album->id) }}"></a>
        @endif
        
        @if($category_delete == 1 && $album->id!=1)

        <a id="delete" data-id='{{ $album->id }}' data-name='{{ $album->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف الالبوم" class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.albums.destroy', $album->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $album->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>
    @endif
</tr>

@endforeach

