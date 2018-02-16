@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 profile-div">
            <div class="col-md-10 profile-header">
                <div class="col-md-3">
                    <img class="avatar-profile" src="{{$user->avatar}}"/>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <h3 class="col-md-5 user-name">{{$user->name}}</h3>
                    <a class = "col-md-5 edit-profile" href="{{route('profile.edit')}}">
                        Edit Profile
                    </a>
                    <a href="{{ route('logout') }}" class = "col-md-2 edit-profile"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <div class="col-md-12 user-name">
                    <p class="col-md-5 user-name">{{$user->followercount}} followers</p>
                    <p class="col-md-6 user-name">{{$user->followingcount}} following</p>
                    </div>
                    <div class="col-md-12 user-name">
                        <p class="col-md-12 user-name">{{$user->name}}</p>
                    </div>
                    <div class="col-md-12 user-name">
                        <p class="col-md-12 user-name">{{$user->bio}}</p>
                    </div>
                </div>
                
            </div>
            @foreach($posts as $post)
            <div class ="col-md-4">
                <a href = "{{route('post.view',['postId'=>$post->id])}}">
                <img src="{{$post->image}}" class = "post-image"></img>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection