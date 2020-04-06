<thead>
    <tr>
        <th>ID</th>
        <!--<th>صاحب الفصل</th>-->
        <th>اسم الفصل</th>
        <th>عدد مشاهدات</th>
        <th>الحالة</th>
        @if($post_edit == 1  || $post_show == 1  || $post_delete == 1 || $comment_list == 1 || $comment_create == 1)
        <th style="width: 350px;">الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $post)
<tr>
    <td>{{ ++$key }}</td>
    <!--<td>{{ $post->user->display_name }} </td>-->
    <td>{{ $post->name }}</td>
    <td>{{ $post->view_count }}</td>
    <td>
    @if($post->is_active == 0)
        <a class="poststatus fa fa-remove btn  btn-danger btn-state"  data-id='{{ $post->id }}' data-status='1' ></a>
    @else
        <a class="poststatus fa fa-check btn  btn-success btn-state"  data-id='{{ $post->id }}' data-status='0' ></a>
    @endif
    </td>
    @if($post_edit == 1  || $post_show == 1  || $post_delete == 1 || $comment_list == 1 || $comment_create == 1)
    <td>
<!--            @if($post_show == 1)
                <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.chapters.show',$post->id) }}"></a>
            @endif-->
            @if($post_edit == 1)
                <a class="btn btn-primary fa fa-edit btn-post" data-toggle="tooltip" data-placement="top" data-title="تعديل الدورة" href="{{ route('admin.chapters.edit',$post->id) }}"></a>
            @endif
            @if($post_delete == 1)
            <a id="delete" data-id='{{ $post->id }}' data-name='{{ $post->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف الدورة" class="btn btn-danger fa fa-trash btn-post"></a>
            {!! Form::open(['method' => 'DELETE','route' => ['admin.chapters.destroy', $post->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $post->id]) !!}
            {!! Form::close() !!}
            @endif
            @if($comment_list == 1 )
            <a class="btn btn-success fa fa-reorder btn-post" data-toggle="tooltip" data-placement="top" data-title=" محاضرات الفصل" href="{{ route('admin.chapters.lectures.index',$post->id) }}"></a>
            @endif
    </td>
    @endif
</tr>
@endforeach