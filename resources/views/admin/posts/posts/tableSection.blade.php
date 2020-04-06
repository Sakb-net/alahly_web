<thead>
    <tr>
        <th>ID</th>

        <th>الاسم</th>
        
        <th>المحتوى</th>
        @if($post_edit == 1)
        <th>الحالة</th>
        @endif
        @if($post_edit == 1  || $post_show == 1  || $post_delete == 1 || $comment_list == 1 || $comment_create == 1)
        <th style="width: 350px;">الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $category)

<tr>

    <td>{{ $category->id }}</td>

    <td>{{ $category->name }}</td>
    
    <td>{{str_limit($category->content, $limit = 80, $end = '...')}}</td>
    @if($post_edit == 1)
    <td>
    @if($category->is_active == 0)
        <a class="categorystatus fa fa-remove btn  btn-danger"  data-id='{{ $category->id }}' data-status='1' ></a>
    @else
        <a class="categorystatus fa fa-check btn  btn-success"  data-id='{{ $category->id }}' data-status='0' ></a>
    @endif
        
    </td>
    @endif
    @if($post_edit == 1  || $post_show == 1 || $post_delete == 1)
    <td>
        <!--if  $post_show == 1-->
        @if($category->type=="main")
        <!--fa-eye-slash-->
        <!--<a class="btn btn-info fa fa-cube btn-post"  data-toggle="tooltip" data-placement="top" data-title="عرض الاقسام الفرعية" href="{{ route('admin.categories.show',$category->id) }}"></a>-->
        @endif
        @if($post_edit == 1)
        <!--<a class="btn btn-primary fa fa-edit btn-post"  data-toggle="tooltip" data-placement="top" data-title="تعديل السكشن" href="{{ route('admin.categories.edit',$category->id) }}"></a>-->
        <a class="btn btn-success fa fa-rocket btn-post"  data-toggle="tooltip" data-placement="top" data-title="مقاعد السكشن" href="{{ route('admin.posts.type.category',[$type,$category->id]) }}"></a>
        @endif
        
        @if($post_delete == 1)
         <a id="delete" data-id='{{ $category->id }}' data-name='كل مقاعد السكشن  {{ $category->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف  " class="btn btn-danger fa fa-trash btn-post"></a>
         {!! Form::open(['method' => 'DELETE','route' => ['admin.posts.deletetype.category', $type,$category->id],'style'=>'display:inline']) !!}
         {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $category->id]) !!}
         {!! Form::close() !!}
         @endif
    </td>
    @endif
</tr>
@endforeach