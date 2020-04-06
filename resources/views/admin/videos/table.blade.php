<thead>
    <tr>
        <th>ID</th>
        <!--<th>صاحب الفصل</th>-->
        <th>اسم الفديو</th>
        <!--<th>عدد مشاهدات</th>-->
        <th>الحالة</th>
        @if($video_edit == 1  || $video_show == 1  || $video_delete == 1 || $comment_list == 1 || $comment_create == 1)
        <th style="width: 350px;">الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $video)
<tr>
    <td>{{ $video->id }}</td>
    <!--<td>{{ $video->user->display_name }} </td>-->
    <td>{{ $video->name }}</td>
    <!--<td>{{ $video->view_count }}</td>-->
    <td>
    @if($video->is_active == 0)
        <a class="videostatus fa fa-remove btn  btn-danger btn-state"  data-id='{{ $video->id }}' data-status='1' ></a>
    @else
        <a class="videostatus fa fa-check btn  btn-success btn-state"  data-id='{{ $video->id }}' data-status='0' ></a>
    @endif
    </td>
    @if($video_edit == 1  || $video_show == 1  || $video_delete == 1 || $comment_list == 1 || $comment_create == 1)
    <td>
<!--            @if($video_show == 1)
                <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.videos.show',$video->id) }}"></a>
            @endif-->
            @if($video_edit == 1)
                <a class="btn btn-primary fa fa-edit btn-video" data-toggle="tooltip" data-placement="top" data-title="تعديل الفديو" href="{{ route('admin.videos.edit',$video->id) }}"></a>
            @endif
            @if($video_delete == 1)
            <a id="delete" data-id='{{ $video->id }}' data-name='{{ $video->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف الفديو" class="btn btn-danger fa fa-trash btn-video"></a>
            {!! Form::open(['method' => 'DELETE','route' => ['admin.videos.destroy', $video->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $video->id]) !!}
            {!! Form::close() !!}
            @endif
    </td>
    @endif
</tr>
@endforeach