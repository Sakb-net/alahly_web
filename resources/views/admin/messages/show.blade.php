@extends('admin.layouts.app')
@section('title') عرض الرسالة 
@stop
@section('head_content')
@include('admin.messages.head')
@stop
@section('content')

<div class="row">
    <div class="col-sm-12">
        <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-primary">
            <!-- /.box-header -->
            <div class="box-body">
                @foreach ($message_all as $key => $message)
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                @if($message->user_id == $user_id)
                <div class="direct-chat-msg ">
                  <div class="direct-chat-info  clearfix">
                    <span class="direct-chat-name pull-left">{{ $user_name }}</span>
                    <span class="direct-chat-timestamp pull-right">{{ $message->created_at }}</span>
                  </div>
                  <!-- /.direct-chat-info -->
                  @if($user_image != NULL)
                        <img src="{{ $user_image }}" class="direct-chat-img" alt="User Image">

                        @else
                        <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="direct-chat-img" alt="User Image">
                        @endif
                  
                  <div class="direct-chat-text">
                    {{ $message->message }}
                  </div>
                  <!-- /.direct-chat-text -->
                </div>
                @else
                <div class="direct-chat-info  clearfix">
                    <span class="direct-chat-timestamp pull-right">{{ $message->created_at }}</span>
                  </div>
                <div class="direct-chat-msg right">
                <div class="direct-chat-text">
                    {{ $message->message }}
                  </div>    
                </div>
                @endif
                <!-- /.direct-chat-msg -->

              </div>
              @endforeach
              <!--/.direct-chat-messages-->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              {!! Form::model($message, ['method' => 'PATCH','route' => ['admin.messages.update', $id],'data-parsley-validate'=>""]) !!}
                <div class="input-group">
                    {!! Form::text('message', "", array('placeholder' => 'Type Message ...','class' => 'form-control','required'=>'')) !!}
                      <span class="input-group-btn">
                          <button type="submit" name="submit" class="btn btn-primary btn-flat">ارسال</button>
                      </span>
                </div>
              {!! Form::close() !!}
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
    </div>
</div>

@stop