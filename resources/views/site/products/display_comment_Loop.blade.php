<!--draw there comment-->
<div class="draw_display_comments" id="draw_display_comments">
    @if($comt_quest_count>0)
        @foreach($comments as $key_comment=>$value_comment)   
            @include('site.products.display_comment_item')
        @endforeach
    @else
    <!--<div class="mt-80 no-questions_found">-->
    <div class="alert alert-info alert-dismissible ajax-message stat_questions_found" role="alert" style="color:#000; background-color:#00cecb;  ">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="icon icon-info"></span>{{trans('app.not_found')}} {{trans('app.comments')}} 
    </div>
    <!--</div>-->
    @endif 
</div>
