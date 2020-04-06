<thead>
    <tr>

        <th>ID</th>

        <th>العضو</th>

        <th>الرسالة</th>

        <th>تاريخ اخر رسالة</th>

        <th>الاعدادات</th>

    </tr>
</thead>

@foreach ($data as $key => $message)

<tr>

    <td>{{ ++$key }}</td>

    <td>
        @if($message->from_user_id == 1)
        {{ App\User::userData( $message->user_id,'display_name') }}
        @else
        {{ App\User::userData( $message->from_user_id,'display_name') }}
        @endif
    </td>
    <td>
        @foreach ($message->messageContent as $message_content)
        @if ($loop->last)
        {{ $message_content->message }}
        @endif
        @endforeach
    </td>
    <td>{{ $message->updated_at }}</td>
    <td>@if($message_create > 0)
        <a class="btn btn-info fa fa-eye-slash" href="{{ route('admin.messages.show',$message->id) }}"></a>
        @endif
    </td>



</tr>

@endforeach