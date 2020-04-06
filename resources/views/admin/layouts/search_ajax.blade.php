<div class="draw_data_search" id="draw_data_search">
@if(isset($data))
<h3> {{trans('app.result')}}  {{trans('app.search')}} :( {!! count($data) !!} )</h3>
<table  id="datatable_search"  data-page-length='50' class='table table-bordered table-striped' data-ride="datatable_search">
    @if($stateType=='user')
    @include('admin.users.table')
    @elseif($stateType=='blog')
    @include('admin.blogs.table')  
    @elseif($stateType=='category')
    @include('admin.categories.table') 
    @elseif($stateType=='order')
    @include('admin.orders.table') 
    @elseif($stateType=='comment')
    @include('admin.comments.table')  
    @endif
</table>
@endif
</div>