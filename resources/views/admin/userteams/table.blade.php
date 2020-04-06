<thead>
    <tr>
        <th>ID</th>
        <th>الاسم</th>
        <!--<th>المحتوى</th>-->
        <th>نوع الاعب</th>
        @if($category_edit == 1)
        <th>الحالة</th>
        @endif
        @if($category_edit == 1  || $category_show == 1 || $category_delete == 1 )
        <th>الاعدادات</th>
        @endif
    </tr>
</thead>

@foreach ($data as $key => $category)

<tr>
    <td>{{ $category->id }}</td>
    <td>{{ $category->name }}</td>    
    <!--<td>{{str_limit($category->content, $limit = 80, $end = '...')}}</td>-->
        <td>{!! get_UserTeamType($category->type_state) !!}</td>
    <td>
    @if($category->is_active == 0)
        <a class="categorystatus fa fa-remove btn  btn-danger"  data-id='{{ $category->id }}' data-status='1' ></a>
    @else
        <a class="categorystatus fa fa-check btn  btn-success"  data-id='{{ $category->id }}' data-status='0' ></a>
    @endif
    </td>
    @if($category_edit == 1  || $category_show == 1 || $category_delete == 1)
    <td>
        @if($category_show == 1)
        <!--<a class="btn btn-info fa fa-eye-slash"  data-toggle="tooltip" data-placement="top" data-title="عرض  لاعبين الفريق" href="{{ route('admin.userclubteams.show',$category->id) }}"></a>-->
        @endif
        @if($category_edit == 1)
        <a class="btn btn-primary fa fa-edit" data-toggle="tooltip" data-placement="top" data-title="تعديل  "  href="{{ route('admin.userclubteams.edit',$category->id) }}"></a>
        @endif
        @if($category_delete == 1)

        <a id="delete" data-id='{{ $category->id }}' data-name='{{ $category->name }}'  data-toggle="tooltip" data-placement="top" data-title="حذف لاعب " class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.userclubteams.destroy', $category->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $category->id]) !!}

        {!! Form::close() !!}

        @endif
        
    </td>
    @endif
</tr>

@endforeach

