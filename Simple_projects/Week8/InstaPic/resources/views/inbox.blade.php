

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 col-md-offset-2 post-div">
            @foreach($directMessages as $directMessage)
            <div class="col-md-12 chat-box">
            <h3>{{$directMessage->sender->displayname}}:</h3>
            <h4>{{$directMessage->content}}</h4>
            </div>            
            <br>
            @endforeach
        </div>
    </div>
</div>
@endsection