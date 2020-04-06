<thead>
    <tr>
        <th>ID</th>
        <th>القسم الرئيسى</th>
        <th>القسم الفرعى</th>
        <th>الدورة</th>
        <th>عدد مشاهدات</th>
        <th>نوع الدورة</th>
        <th>الحالة</th>
        @if($post_edit == 1  || $post_show == 1  || $post_delete == 1 || $comment_list == 1 || $comment_create == 1)
        <th>الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $post)
<tr>
    <td>{{ ++$key }}</td>
    <td>{{ $post->user->display_name }} </td>
    <td>{{ $post->name }}</td>
    <td><img  src="{{ $post->image }}"  width="75px" height="75px" @if($post->image == Null)  style="display:none;" @endif /></td>
    <td>{{ $post->content }}</td>
    @if($post_active == 1 )
    <td>
            @if($post->is_read == 0)
                <a class="postread fa fa-remove btn  btn-danger"  data-id='{{ $post->id }}' ></a>
            @else
                <a class="fa fa-check btn  btn-success"  data-id='{{ $post->id }}' ></a>
            @endif
    </td>
    <td>
            @if($post->is_active == 0)
                <a class="poststatus fa fa-remove btn  btn-danger"  data-id='{{ $post->id }}' data-status='1' ></a>
            @else
                <a class="poststatus fa fa-check btn  btn-success"  data-id='{{ $post->id }}' data-status='0' ></a>
            @endif
    </td>
    @endif
    @if($post_edit == 1  || $post_show == 1  || $post_delete == 1 || $comment_list == 1 || $comment_create == 1)
    <td>
<!--            @if($post_show == 1)
                <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.courses.show',$post->id) }}"></a>
            @endif-->
            @if($post_edit == 1)
                <a class="btn btn-primary fa fa-edit" data-toggle="tooltip" data-placement="top" data-title="تعديل الدورة" href="{{ route('admin.courses.edit',$post->id) }}"></a>
            @endif
            @if($post_delete == 1)
            <a id="delete" data-id='{{ $post->id }}' data-toggle="tooltip" data-placement="top" data-title="حذف الدورة" class="btn btn-danger fa fa-trash"></a>
            {!! Form::open(['method' => 'DELETE','route' => ['admin.courses.destroy', $post->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $post->id]) !!}
            {!! Form::close() !!}
            @endif
            @if($comment_list == 1 )
            <a class="btn btn-success fa fa-commenting" data-toggle="tooltip" data-placement="top" data-title="اسئلة وملاحظات الدورة" href="{{ route('admin.courses.comments.index',$post->id) }}"></a>
            @endif
<!--            @if($comment_create == 1 )
            <a class="btn btn-info fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="الدورات" href="{{ route('admin.courses.comments.create',$post->id) }}"></a>
            @endif-->
    </td>
    @endif
</tr>
@endforeach