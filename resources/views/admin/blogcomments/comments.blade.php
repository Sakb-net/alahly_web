<thead>
    <tr>
        <th>ID</th>
        <th>ip</th>
        <th>{{trans('app.name')}} </th>
        <th>{{trans('app.email')}} </th>
        <th>{{trans('app.comment')}} </th>
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
    <td>{{ ++$key }}</td>
    <td>{{ $comment->visitor }}</td>
    <td>{{ $comment->name }} </td>
    <td>{!! str_replace('@', '@ ', $comment->email) !!}</td>
    <td>{!! str_limit($comment->content,$limit = 50, $end = '...')  !!}</td>
    @if($comment_active == 1 )
    <td>
            @if($comment->is_read == 0)
                <a class="commentread fa fa-remove btn  btn-danger"  data-id='{{ $comment->id }}' ></a>
            @else
                <a class="fa fa-check btn  btn-success"  data-id='{{ $comment->id }}' ></a>
            @endif
    </td>
    <td>
            @if($comment->is_active == 0)
                <a class="commentstatus fa fa-remove btn  btn-danger"  data-id='{{ $comment->id }}' data-status='1' ></a>
            @else
                <a class="commentstatus fa fa-check btn  btn-success"  data-id='{{ $comment->id }}' data-status='0' ></a>
            @endif
    </td>
    @endif
    @if($comment_edit == 1  || $comment_delete == 1)
    <td>
            @if($comment_edit == 1)
            <a class="btn btn-info fa fa-commenting" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.view')}} " href="{{ route('admin.blogcomments.show',$comment->id) }}"></a>
            <a class="btn btn-primary fa fa-edit" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.update')}} " href="{{ route('admin.blogcomments.edit',$comment->id) }}"></a>
            <a class="btn btn-success fa fa-plus" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.repay')}} " href="{{ route('admin.blogcomments.reply',$comment->id) }}"></a>
            @endif
            
            @if($comment_delete == 1)
            <a id="delete" data-id='{{ $comment->id }}' data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.delete')}} " class="btn btn-danger fa fa-trash"></a>
            {!! Form::open(['method' => 'DELETE','route' => ['admin.blogcomments.destroy', $comment->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $comment->id]) !!}
            {!! Form::close() !!}
            @endif
    </td>
    @endif
</tr>
@endforeach