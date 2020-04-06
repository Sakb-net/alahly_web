<thead>
    <tr>
        <th>ID</th>
        <th>{{trans('app.name')}} </th>
        <th>{{trans('app.detail_desc')}} </th>
        <th style="width: 100px;" >{{trans('app.create_at')}} </th>
        <th>{{trans('app.num_view')}} </th>
        <th>{{trans('app.state')}} </th>
         <th>
            @foreach ($mainLanguage as $kyLang => $Langval)
                <div class="btn-lang">{{$Langval}}</div>
            @endforeach
        </th>
        @if($blog_edit == 1  || $blog_show == 1  || $blog_delete == 1 || $comment_list == 1 || $comment_create == 1)
        <th style="width:150px;">{{trans('app.settings')}} </th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $blog)
<tr>
    <td>{{ $blog->id }}</td>
    <td  class='main-td'>{{ $blog->name }} </td>
    <td>{!! str_limit($blog->content, $limit = 50, $end = '...')!!}</td>
    <td>{{ $blog->created_at }}</td>
    <td>{{ $blog->view_count }}</td>
    <td>
    @if($blog->is_active == 0)
        <a class="blogstatus fa fa-remove btn  btn-danger btn-state"  data-id='{{ $blog->id }}' data-status='1' ></a>
    @else
        <a class="blogstatus fa fa-check btn  btn-success btn-state"  data-id='{{ $blog->id }}' data-status='0' ></a>
    @endif
    </td>
    @if($blog->lang =='ar')
    <td style="padding-right:32px;">
        <?php $foundLang=[]; $Languages= App\Model\Blog::DataLangAR($blog->id); ?>
        @foreach ($Languages as $keyLang => $Lang)
            <?php $foundLang[]= $Lang->lang;?>
                <a class="fa fa-edit btn-lang" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.update')}}  {{trans('app.lang')}} " href="{{ route('admin.blogs.editLang',[$Lang->id,$Lang->lang]) }}"></a>
        @endforeach
        @foreach ($mainLanguage as $keymainLang => $mainLang)
           @if(!in_array($mainLang, $foundLang))
                <a class="btn-add fa fa-plus btn-lang" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.add')}}  {{trans('app.lang')}} " href="{{ route('admin.blogs.createLang',[$blog->id,$mainLang]) }}"></a>
            @endif
        @endforeach
    </td>
    @else
    <td>{{$blog->lang}}</td>
    @endif
    @if($blog_edit == 1  || $blog_show == 1  || $blog_delete == 1 || $comment_list == 1 || $comment_create == 1)
    <td>
<!--            @if($blog_show == 1)
                <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.blogs.show',$blog->id) }}"></a>
            @endif-->
            @if($blog_edit == 1)
                <a class="btn btn-primary fa fa-edit btn-blog" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.update')}}  {{trans('app.new_one')}} " href="{{ route('admin.blogs.edit',$blog->id) }}"></a>
            @endif
           
            @if($comment_list == 1 && $blog->lang =='ar')
                <a style="background-color:#083e25;" class="btn btn-success fa fa-language btn-blog" data-toggle="tooltip" data-placement="top" data-title=" {{trans('app.lang')}}  {{trans('app.new_one')}} " href="{{ route('admin.blogs.languages.index',$blog->id) }}"></a>
                <a style="background-color:#436209; " class="btn btn-success fa fa-commenting btn-blog" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.comments')}} {{trans('app.new_one')}} " href="{{ route('admin.blogs.comments.index',$blog->id) }}"></a>
              
    <!--            <a id="Makearrange" data-id='{{ $blog->id }}' data-name='{{ $blog->name }}' class="btn btn-primary fa fa-exchange btn-blog" data-toggle="tooltip" data-placement="top" data-title=" اعادة{{trans('app.arrange')}}  {{trans('app.new_one')}} " style="background-color:#840e7e; "  ></a>
                {!! Form::open(['method' => 'blog','route' => ['admin.blogs.arrange.index', $blog->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-arrange-id' => $blog->id]) !!}
                {!! Form::close() !!}-->   
            @endif
         <!--@if($comment_create == 1 )
            <a class="btn btn-info fa fa-plus" data-toggle="tooltip" data-placement="top" data-title="{{trans('app.new_ones')}} " href="{{ route('admin.blogs.comments.create',$blog->id) }}"></a>
            @endif-->
           @if($blog_delete == 1)
            <a id="delete" data-id='{{ $blog->id }}' data-name='{{ $blog->name }}' data-toggle="tooltip" data-placement="top" data-title="{{trans('app.delete')}}  {{trans('app.new_one')}} " class="btn btn-danger fa fa-trash btn-blog"></a>
            {!! Form::open(['method' => 'DELETE','route' => ['admin.blogs.destroy', $blog->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $blog->id]) !!}
            {!! Form::close() !!}
            @endif
    </td>
    @endif
</tr>
@endforeach