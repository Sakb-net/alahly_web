<thead>
    <tr>

        <th>ID</th>
        <th>الفريق الرئيسيى </th>
        <th>الفريق الفرعى </th>
        <th>الاسم</th>
        <!--<th>المحتوى</th>-->
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
    @php $data_subcat=App\Model\Category::get_categoryID($category->parent_id,'name',1) @endphp
    @if(isset($data_subcat->parent_id))
        @if($data_subcat->parent_id>0)
        @php $data_cat=App\Model\Category::get_categoryID($data_subcat->parent_id,'name',1) @endphp
        <td>{{$data_cat->name}} </td>
        <td>{{$data_subcat->name}} </td>
        @else
            <td>{{$data_subcat->name}} </td>
            <td  class='main-td'>{{trans('app.not_found')}}  {{trans('app.team')}} </td>
        @endif
    @else
        <td  class='main-td'>{{trans('app.not_found')}}  {{trans('app.team')}} </td>
        <td  class='main-td'>{{trans('app.not_found')}}  {{trans('app.team')}} </td>
    @endif

    <td>{{ $category->name }}</td>

<!--<td>{{str_limit($category->content, $limit = 80, $end = '...')}}</td>-->
    @if($category_edit == 1)
    <td>
        @if($category->is_active == 0)
        <a class="categorystatus fa fa-remove btn  btn-danger"  data-id='{{ $category->id }}' data-status='1' ></a>
        @else
        <a class="categorystatus fa fa-check btn  btn-success"  data-id='{{ $category->id }}' data-status='0' ></a>
        @endif

    </td>
    @endif
    @if($category_edit == 1  || $category_show == 1 || $category_delete == 1)
    <td>
        <!--if  $category_show == 1-->
        @if($category->type=="team")
        <!--fa-eye-slash-->
        <!--<a class="btn btn-info fa fa-cube"  data-toggle="tooltip" data-placement="top" data-title="عرض الاقسام الفرعية" href="{{ route('admin.champions.show',$category->id) }}"></a>-->
        @endif
        @if($category_edit == 1)
        <a class="btn btn-primary fa fa-edit"  data-toggle="tooltip" data-placement="top" data-title=" تعديل" href="{{ route('admin.champions.edit',$category->id) }}"></a>
        @endif
        @if($category_delete == 1)

        <a id="delete" data-id='{{ $category->id }}' data-name='{{ $category->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف البطولة " class="btn btn-danger fa fa-trash"></a>

        {!! Form::open(['method' => 'DELETE','route' => ['admin.champions.destroy', $category->id],'style'=>'display:inline']) !!}

        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $category->id]) !!}

        {!! Form::close() !!}

        @endif

    </td>
    @endif
</tr>

@endforeach

