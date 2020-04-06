<a data-toggle="modal" class="model_msg_booking" id="model_msg_booking" data-target="#msg_booking"></a>
<div id="msg_booking" class="modal fade sizeModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!--<h4 class="modal-title"></h4>-->
            </div>
            <div class="modal-body ">
                <div class="mlab_chair">
                    <p class="p_booking">{!!$msg_booking!!}</p>
                </div>
            </div>
            <div class="modal-footer foot_booking">
                <a href="{{ route('matches.next') }}" class="butn butn-bg pull-right"><span>المباريات القادمة</span></a>
            </div>
        </div>
    </div>
</div>
