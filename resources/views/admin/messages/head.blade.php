<div class="row">

	    <div class="col-lg-12 margin-tb">

	        <div class="pull-right">
                     @if(Auth::user()->can('access-all', 'service-all','message-all','message-list'))
	            <a class="btn btn-primary fa fa-paint-brush" href="{{ route('admin.messages.index') }}"></a>

                    <a class="btn btn-info fa fa-search" href="{{ route('admin.messages.search') }}"></a>
                    @endif
	        </div>

	    </div>

	</div>
