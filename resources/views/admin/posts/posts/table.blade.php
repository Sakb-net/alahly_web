<h1>سكشن : {{$category->name}}</h1>
<thead>
    <tr>
        <th>ID</th>
        <th>اسم </th>
        <th>رقم الصف, رقم المقعد </th>
        @if($type!='banner'&&$type!='chair')
        <th>عدد مشاهدات</th>
        @endif
        <th>الحالة</th>
        @if($post_edit == 1  || $post_show == 1  || $post_delete == 1 || $comment_list == 1 || $comment_create == 1)
        <th style="width: 350px;">الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $post)
<tr>
    <td>{{ $post->id }}</td>
    <!--<td>{{ ++$key }}</td>-->
    <td>{{ $post->name }}</td>
    <td>{!!getNum_rowChart($post->row)!!}</td>
    @if($type!='banner'&&$type!='chair')
    <td>{{ $post->view_count }}</td>
    @endif
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
                <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.posts.show',$post->id) }}"></a>
            @endif-->
            @if($post_edit == 1)
                <a class="btn btn-primary fa fa-edit btn-post" data-toggle="tooltip" data-placement="top" data-title="تعديل  " href="{{ route('admin.posts.edittype',[$post->id,$type]) }}"></a>
            @endif
           
            @if($comment_list == 1 )
            <!--<a  class="btn btn-warning fa fa-file-video-o btn-post" data-toggle="tooltip" data-placement="top" data-title=" فديوهات  (post)" href="{{ route('admin.posts.videos.index',$post->id) }}"></a>-->
            <!--<a class="btn btn-info fa fa-file-pdf-o btn-post" data-toggle="tooltip" data-placement="top" data-title=" ملفات اسم (post)" href="{{ route('admin.posts.files.index',$post->id) }}"></a>-->
            <!--<a style="background-color:#436209; " class="btn btn-success fa fa-commenting btn-post" data-toggle="tooltip" data-placement="top" data-title=" تعليقات  (post)" href="{{ route('admin.posts.comments.index',$post->id) }}"></a>-->
          @endif
           @if($post_delete == 1)
            <a id="delete" data-id='{{ $post->id }}' data-name='{{ $post->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف  " class="btn btn-danger fa fa-trash btn-post"></a>
            {!! Form::open(['method' => 'DELETE','route' => ['admin.posts.destroy', $post->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $post->id]) !!}
            {!! Form::close() !!}
            @endif
    </td>
    @endif
</tr>
@endforeach