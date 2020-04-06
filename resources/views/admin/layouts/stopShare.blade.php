<div class="modal fade" id="stopShare-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">توقف اشتراك {{$type_action}}</h4>
                </div>
                <div class="modal-body">
                    هل تريد تاكيد توقف اشتراك {{$type_action}} ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">لا</button>
                    <button id="confirm-stopShare" type="button" class="btn btn-success">نعم</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '#MakestopShare', function(){
            $('#stopShare-modal').modal('show');
            $('#confirm-stopShare').attr('data-id', $(this).attr('data-id'));
            var title_h='  توقف اشتراك {{$type_action}}'+' : '+$(this).attr('data-name');
            var text_div=' هل تريد تاكيد  توقف اشتراك  {{$type_action}} ؟'+' : '+$(this).attr('data-name');
            $( "h4.modal-title" ).text(title_h);
            $( "div.modal-body" ).text(text_div);
        });
        
        $('body').on('click', '#confirm-stopShare', function(){ 
    
        $('#stopShare-modal').modal('hide');
        
        $('[data-stopShare-id="' + $(this).attr('data-id') + '"]').click();

    });
    
  });
  </script>
