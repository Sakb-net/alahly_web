<div class="bi-noti-upload"></div>
<div class="draw_category_product" id="draw_category_product">
    @if(count($products)>0)
        @include('site.products.ajax_product')
    @else    
      @include('site.products.body_empty')
    @endif
</div>