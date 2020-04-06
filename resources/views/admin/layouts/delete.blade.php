<div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">حذف {{$type_action}}</h4>
                </div>
                <div class="modal-body">
                    هل تريد تاكيد حذف {{$type_action}} ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">لا</button>
                    <button id="confirm-delete" type="button" class="btn btn-danger">نعم</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '#delete', function(){
            $('#delete-modal').modal('show');
            $('#confirm-delete').attr('data-id', $(this).attr('data-id'));
            var title_h=' الحذف {{$type_action}}'+' : '+$(this).attr('data-name');
            var text_div=' هل تريد تاكيد الحذف  {{$type_action}} ؟'+' : '+$(this).attr('data-name');
            $( "h4.modal-title" ).text(title_h);
            $( "div.modal-body" ).text(text_div);
        });
        
        $('body').on('click', '#confirm-delete', function(){ 
    
        $('#delete-modal').modal('hide');
        
        $('[data-delete-id="' + $(this).attr('data-id') + '"]').click();

    });
    
  });
  </script>
