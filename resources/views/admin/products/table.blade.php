<thead>
    <tr>
        <th>ID</th>
        <th>القسم الرئيسيى </th>
        <th>القسم الفرعى </th>
        <th>اسم </th>
        <th>العدد المتاح</th>
        <th>العدد المباع</th>
        <th>تاريخ</th>
        <th>عدد مشاهدات</th>
        <th>الحالة</th>
        @if($product_edit == 1  || $product_show == 1  || $product_delete == 1 || $comment_list == 1 || $comment_create == 1)
        <th style="width: 150px;">الاعدادات</th>
        @endif
    </tr>
</thead>
@foreach ($data as $key => $product)
<tr>
    <td>{{ $product->id }}</td>
    @if(count($product->categories)!=0)
    @if($product->categories[0]->parent_id == 0)
    <td>{{ $product->categories[0]->name }} </td>
    <td  class='sub-td'>{{trans('app.not_found')}} {{trans('app.subCategory')}}  </td>
    @else
    <td>{!! App\Model\CategoryProduct::get_categoryID($product->categories[0]->parent_id,'name') !!} </td>
    <td>{{ $product->categories[0]->name }} </td>
    @endif
    @else
    <td  class='main-td'>{{trans('app.not_found')}}  {{trans('app.Category')}} </td>
    <td  class='sub-td'>{{trans('app.not_found')}} {{trans('app.subCategory')}}  </td>
    @endif
    <td>{{ $product->name }}</td>
    <td>{{ $product->number_prod }}</td>
    <td>{{ $product->sale_number_prod }}</td>
    <td>{{ $product->created_at }}</td>
    <td>{{ $product->view_count }}</td>
    <td>
        @if($product->is_active == 0)
        <a class="productstatus fa fa-remove btn  btn-danger btn-state"  data-id='{{ $product->id }}' data-status='1' ></a>
        @else
        <a class="productstatus fa fa-check btn  btn-success btn-state"  data-id='{{ $product->id }}' data-status='0' ></a>
        @endif
    </td>
    @if($product_edit == 1  || $product_show == 1  || $product_delete == 1 || $comment_list == 1 || $comment_create == 1)
    <td>
<!--            @if($product_show == 1)
                <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.products.show',$product->id) }}"></a>
            @endif-->
        @if($product_edit == 1)
        <a class="btn btn-primary fa fa-edit btn-product" data-toggle="tooltip" data-placement="top" data-title="تعديل  " href="{{ route('admin.products.edit',$product->id) }}"></a>
        @endif

        @if($comment_list == 1 )
        <a style="background-color:#436209; " class="btn btn-success fa fa-commenting btn-product" data-toggle="tooltip" data-placement="top" data-title=" تعليقات  (product)" href="{{ route('admin.products.comments.index',$product->id) }}"></a>
        @endif
        @if($product_delete == 1)
        <a id="delete" data-id='{{ $product->id }}' data-name='{{ $product->name }}' data-toggle="tooltip" data-placement="top" data-title="حذف  " class="btn btn-danger fa fa-trash btn-product"></a>
        {!! Form::open(['method' => 'DELETE','route' => ['admin.products.destroy', $product->id],'style'=>'display:inline']) !!}
        {!! Form::submit('Delete', ['class' => 'hide btn btn-danger delete-btn-submit','data-delete-id' => $product->id]) !!}
        {!! Form::close() !!}
        @endif
    </td>
    @endif
</tr>
@endforeach