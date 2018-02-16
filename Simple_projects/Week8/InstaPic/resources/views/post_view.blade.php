@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 col-md-offset-2 post-div">
            <div class="col-md-12">
                <a href="" class="col-md-12">
                    <img class="avatar" src="{{$post->user->avatar}}"/>
                    <p class="col-md-8 user-name">{{$post->user->name}}</p>
                </a>
                @if($post->user->followers->find(Auth::id()) === null)
                    <a class="col-md-1 col-md-offset-4 user-name" href="{{route('user.follow',['userId'=>$post->user->id])}}"/>
                    Follow</a> 
                @endif
            </div>
            <div class="col-md-12">
            <img src="{{$post->image}}" class="post-image"></img>
            </div>
            <div class="col-md-12">
                @if($post->liked->find(Auth::id()) !==null)
                <div class = "col-md-1">
                    <a href="{{route('post.unlike',['postId'=>$post->id])}}">
                        <svg version="1.1" width="30px" height="30px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                            <path style="fill:#D75A4A;" d="M24.85,10.126c2.018-4.783,6.628-8.125,11.99-8.125c7.223,0,12.425,6.179,13.079,13.543
                                c0,0,0.353,1.828-0.424,5.119c-1.058,4.482-3.545,8.464-6.898,11.503L24.85,48L7.402,32.165c-3.353-3.038-5.84-7.021-6.898-11.503
                                c-0.777-3.291-0.424-5.119-0.424-5.119C0.734,8.179,5.936,2,13.159,2C18.522,2,22.832,5.343,24.85,10.126z"/>
                    </a>
                </div>
                @else
                <div class = "col-md-1">
                    <a href="{{route('post.like',['postId'=>$post->id])}}">
                        <svg version="1.1"  width="30px" height="30px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 51.997 51.997" style="enable-background:new 0 0 51.997 51.997;" xml:space="preserve">
                            <path d="M51.911,16.242C51.152,7.888,45.239,1.827,37.839,1.827c-4.93,0-9.444,2.653-11.984,6.905
                                c-2.517-4.307-6.846-6.906-11.697-6.906c-7.399,0-13.313,6.061-14.071,14.415c-0.06,0.369-0.306,2.311,0.442,5.478
                                c1.078,4.568,3.568,8.723,7.199,12.013l18.115,16.439l18.426-16.438c3.631-3.291,6.121-7.445,7.199-12.014
                                C52.216,18.553,51.97,16.611,51.911,16.242z M49.521,21.261c-0.984,4.172-3.265,7.973-6.59,10.985L25.855,47.481L9.072,32.25
                                c-3.331-3.018-5.611-6.818-6.596-10.99c-0.708-2.997-0.417-4.69-0.416-4.701l0.015-0.101C2.725,9.139,7.806,3.826,14.158,3.826
                                c4.687,0,8.813,2.88,10.771,7.515l0.921,2.183l0.921-2.183c1.927-4.564,6.271-7.514,11.069-7.514
                                c6.351,0,11.433,5.313,12.096,12.727C49.938,16.57,50.229,18.264,49.521,21.261z"/>
                    </a>
                </div>
                @endif
                <div class = "col-md-1">
                    <a href="{{route('direct.message',['userId'=>$post->user->id])}}">
                    <svg version="1.1"  width="30px" height="30px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 33 33" style="enable-background:new 0 0 33 33;" xml:space="preserve">
                        <path d="M7.282,32.706c-0.081,0-0.163-0.02-0.237-0.06c-0.162-0.087-0.263-0.257-0.263-0.44v-7.124C2.405,22.806,0,18.821,0,13.828
                            C0,6.112,7.093,0.294,16.5,0.294S33,6.112,33,13.828c0,7.715-7.093,13.533-16.5,13.533c-0.309,0-0.612-0.017-0.916-0.033
                            l-0.02-0.001l-8.007,5.296C7.474,32.678,7.378,32.706,7.282,32.706z M16.5,1.294C7.664,1.294,1,6.683,1,13.828
                            c0,3.323,1.128,7.842,6.503,10.499c0.17,0.084,0.278,0.258,0.278,0.448v6.501l7.369-4.874c0.09-0.06,0.199-0.095,0.302-0.082
                            l0.186,0.01c0.286,0.016,0.571,0.031,0.861,0.031c8.836,0,15.5-5.388,15.5-12.533S25.336,1.294,16.5,1.294z"/>
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <p class="user-name">{{$post->likecount}} Likes</p>
            </div>
            <div class="col-md-12">
                <p class="user-name">{{$post->user->name}}: {{$post->caption}}</p>
            </div>
            @foreach($post->comments as $comment)
            <div class="col-md-12">
                <p class="user-name">{{$comment->user->name}}: {{$comment->content}}</p>
                @foreach($comment->replies as $reply)
                    <div class="col-md-9 col-md-offset-3">
                        <p class="user-name">{{$reply->user->name}}: {{$reply->content}}</p>
                    </div>
                @endforeach
                <div class="col-md-9 col-md-offset-3">
                    {!! Form::open(array('route'=> ['post.reply',$comment->id],'class'=>'form-create')) !!}
                        {{ csrf_field() }}
                        {!! Form::label('content', ' ', ['class' => 'input-textarea-label']) !!}
                        {{$errors->first('content')}}
                        {!! Form::text('content', '',['class'=>'col-md-4 input-textarea','placeholder'=>'Add a comment...']) !!}
                        {!! Form::submit('Send',['class' => 'form-button']) !!}
                    {!! Form::close() !!}
                </div>
                
            </div>
            @endforeach
            <div class="col-md-12">
                {!! Form::open(array('route'=> ['post.comment',$post->id],'class'=>'form-create')) !!}
                    {{ csrf_field() }}
                    {!! Form::label('content', ' ', ['class' => 'input-textarea-label']) !!}
                    {{$errors->first('content')}}
                    {!! Form::text('content', '',['class'=>'input-textarea','placeholder'=>'Add a comment...']) !!}
                    {!! Form::submit('Send',['class' => 'form-button']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection