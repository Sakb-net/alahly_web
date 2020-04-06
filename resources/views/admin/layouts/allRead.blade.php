<div class="modal fade" id="allRead-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{trans('app.all_view')}} {{$type_action}}</h4>
                </div>
                <div class="modal-body">
                    {{trans('app.do_want')}} {{trans('app.all_view')}} {{$type_action}} ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('app.no')}} </button>
                    <button id="confirm-allRead" type="button" class="btn btn-success">{{trans('app.yes')}} </button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '#MakeallRead', function(){
            $('#allRead-modal').modal('show');
            $('#confirm-allRead').attr('data-id', $(this).attr('data-id'));
            var title_h="{{trans('app.all_view')}} {{$type_action}}"+" : "+$(this).attr('data-name');
            var text_div="{{trans('app.do_want')}} {{trans('app.all_view')}} {{$type_action}} ؟"+" : "+$(this).attr('data-name');
            $( "h4.modal-title" ).text(title_h);
            $( "div.modal-body" ).text(text_div);
        });
        
        $('body').on('click', '#confirm-allRead', function(){ 
    
        $('#allRead-modal').modal('hide');
        
        $('[data-allRead-id="' + $(this).attr('data-id') + '"]').click();

    });
    
  });
  </script>
