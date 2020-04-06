<div class="row">

	    <div class="col-lg-12 margin-tb">

	        <div class="pull-right">
                    @if(Auth::user()->can('access-all', 'user-all','user-list'))
	            <a class="btn btn-primary fa fa-user" data-toggle="tooltip" data-placement="top" data-title="المستخدمين" href="{{ route('admin.users.index') }}"></a>
                    <a class="btn btn-info fa fa-search" data-toggle="tooltip" data-placement="top" data-title="بحث المستخدمين" href="{{ route('admin.users.search') }}"></a>
                    @endif
	        </div>

	    </div>

	</div>
