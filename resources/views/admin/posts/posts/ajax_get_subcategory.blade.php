<div class="draw_get_subcategory" id="draw_get_subcategory">
    @if(count($subcategories)!=0)
    <div class="form-group">
        <label> القسم الفرعى </label>
            {!! Form::select('category_id',$subcategories ,$postSubcategories, array('class' => 'select2','required'=>'')) !!}
    <!--    <select name="category_id"  class="select" style="width:100%;padding: 8px 8px;">
            <option value="0"> اختر القسم الفرعى</option>
            foreach (subcategories as key  subcategory)
                <option value="subcategory->id"> subcategory->name</option>
            <option value="0"> لا يوجد قسم فرعى تابع لهذا القسم</option>
            endforeach
        </select>-->
    </div>

    @endif
</div>
