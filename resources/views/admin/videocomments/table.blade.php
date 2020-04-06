<thead>
    <tr>
        <th>ID</th>
        <!--<th>{{trans('app.name')}} </th>-->
        <th>{{trans('app.email')}} </th>
        <th>{{trans('app.comment')}} </th>
        <!--<th>{{trans('app.type')}}  {{trans('app.comment')}} </th>-->
        @if($comment_active == 1 )
        <th>{{trans('app.read')}} </th>
        <th>{{trans('app.state')}} </th>
        @endif
        @if($comment_edit == 1 || $comment_delete == 1)
        <th>{{trans('app.settings')}} </th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $comment)
<tr>
    <!--++$key-->
    <td>{{ $comment->id }}</td>
    <!--<td>{{ $comment->name }} </td>-->
    <td>{!! str_replace('@', '@ ', $comment->email) !!}</td>
    <td>{!! str_limit($comment->content,$limit = 50, $end = '...')  !!}</td>
    <!--<td>{{$comment->type}}</td>-->
    @if($comment_active == 1 )
    <td>
        @if($comment->is_read == 0)
        <a class="commentread fa fa-remove btn  btn-danger btn-state"  data-id='{{ $comment->id }}' ></a>
        @else
        <a class="fa fa-check btn  btn-success btn-state"  data-id='{{ $comment->id }}' ></a>
        @endif
    </td>
    <td>
        @if($comment->is_active == 0)
        <a class="commentstatus fa fa-remove btn  btn-danger btn-state"  data-id='{{ $comment->id }}' data-status='1' ></a>
        @else
        <a class="commentstatus fa fa-check btn  btn-success btn-state"  data-id='{{ $comment->id }}' data-status='0' ></a>
        @endif
    </td>
    @endif
    @if($comment_edit == 1  || $comment_delete == 1)
    <td>
        @if($comment_edit == 1)
        <a class="btn btn-primary fa fa-edit btn-user" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.update')}} " href="{{ route('admin.videocomments.edit',$comment->id) }}"></a>
        <a class="btn btn-info fa fa-commenting btn-user" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.view')}}  {{trans('app.replaies')}}  " href="{{ route('admin.videocomments.show',$comment->id) }}"></a>
        <a class="btn btn-success fa fa-plus btn-user" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.add')}}  {{trans('app.replay')}} " href="{{ route('admin.videocomments.reply',$comment->id) }}"></a>
        @endif

        @if($comment_delete == 1)
        <a id="delete" data-id='{{ $comment->id }}' data-name='{{ $comment->name }}' data-toggle="tooltip" data-placement="top" data-title="{{trans('app.delete')}}  " class="btn btn-danger fa fa-trash btn-user"></a>
        {!! Form::open(['method' => 'DELETE','route' => ['admin.videocomments.destroy', $comment->id],'style'=>'display:inline']) !!}
        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $comment->id]) !!}
        {!! Form::close() !!}
        @endif
    </td>
    @endif
</tr>
@endforeach