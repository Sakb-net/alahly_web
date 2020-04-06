<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>الاسم:</label>
                    <label>{{ $contact->name }}</label>
                </div>
                <div class="form-group">
                    <label>البريد الالكترونى:</label>
                    <label>{{ $contact->email }}</label>
                </div>
                <div class="form-group">
                    <label>الرسالة:</label>
                    <label>{{ $contact->content }}</label>
                </div>
                
                @if(!empty($contact_reply))
                <h3>الرودد السابقة </h3>
                <div class="row">
                <div class="col-sm-4">
                   <label>عنوان الرسالة على البريد الالكترونى:</label> 
                </div>
                <div class="col-sm-8">
                   <label>الرسالة:</label>
                </div>
                </div>
                @foreach($contact_reply as $key => $v)
                <div class="row">
                <div class="col-sm-4">
                    <label>{{ $v->title }}</label>  
                </div>
                <div class="col-sm-8">
                    <label>{{ $v->content }}</label>  
                </div>
                </div>
                @endforeach
                @endif
                <div class="clearfix m-b-lg"></div>
                <div class="form-group">
                    <label>عنوان الرسالة على البريد الالكترونى:</label>
                    {!! Form::text('title', "", array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="form-group">
                    <label>الرسالة:</label>
                    {!! Form::textarea('content', "", array('class' => 'form-control','required'=>'')) !!}
                </div>
                <div class="box-footer text-center">
                       <button type="submit" class="btn btn-info padding-40" >حفظ</button>
                    <a href="{{$link_return}}" class="btn btn-primary padding-30">رجوع</a>
                </div>
            </div>
        </div>
    </div>
</div>

