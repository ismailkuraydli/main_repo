@extends('layouts.app')

@section('content')
    @if($messages)
    @foreach($messages as $message)
        <div class = "col-md-12 message-box">
            <div class = "message-header">
                   <p class = "time-stamp">{{date_format(date_create($message->created_at),'l, M d,Y H:i A')}}</p>
                <p class = "user-name">{{$message->user->name}}</p>
            </div>
            <div class = "message-content">
                <p class = "message">{{$message->content}}</p>
            </div>
        </div>
    @endforeach
    @endif
    <input type="hidden" name="chatmessage" value="{{Auth::id()}}" id = "id">
    <input type="hidden" name="chatmessage" value="{{$user->name}}" id = "name">
    {{csrf_field()}}
@endsection
