@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-blog">
                <div class="panel-heading page-title"><h1>{{$blogName}}</h1></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!$posts->isEmpty())
                        @if($blogOwner)
                        <div class="view-blog div-post paper-material ">
                            <a class="link-post" href="http://localhost/Week8/BlogPage/public/post/create/{{$blogId}}">
                                <h2 class = "post-title">Create Post</h2>
                            </a>
                        </div>
                        @endif
                        @foreach ($posts as $post)
                            <div class="view-blog div-post paper-material">
                                
                                <a href="{{route('post',['postId'=>$post['id']])}}" class="link-post">
                                    <h2 class = "post-title">{{$post['title']}}</h2>
                                    <img class = "image-post" src = '{{$post['image']}}'></img>
                                </a>
                            @if($blogOwner)
                                <div class="post-footer">
                                    <a href="{{route('post.edit',['postId'=>$post['id']])}}">
                                        <svg class="svg-icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            width="25px" height="25px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                            <path d="M30.276,1.722C29.168,0.611,27.69,0,26.121,0s-3.045,0.61-4.154,1.72L4.294,19.291c-0.105,0.104-0.185,0.229-0.235,0.367
                                                    l-4,11c-0.129,0.355-0.046,0.756,0.215,1.031C0.466,31.891,0.729,32,1,32c0.098,0,0.196-0.014,0.293-0.044l9.949-3.052
                                                    c0.156-0.047,0.298-0.133,0.414-0.248l18.621-18.621C31.389,8.926,32,7.448,32,5.878C31.999,4.309,31.389,2.832,30.276,1.722z
                                                    M10.092,27.165l-3.724,1.144c-0.217-0.637-0.555-1.201-1.016-1.662c-0.401-0.399-0.866-0.709-1.356-0.961L5.7,21H8v2
                                                    c0,0.553,0.447,1,1,1h1.765L10.092,27.165z M24.812,12.671L12.628,24.855l0.35-1.647c0.062-0.296-0.012-0.603-0.202-0.837
                                                    C12.586,22.136,12.301,22,12,22h-2v-2c0-0.552-0.448-1-1-1H7.422L19.315,7.175l0.012,0.011c0.732-0.733,1.707-1.136,2.742-1.136
                                                    s2.011,0.403,2.742,1.136s1.138,1.707,1.138,2.743C25.949,10.965,25.546,11.938,24.812,12.671z M28.862,8.621L27.93,9.554
                                                    c-0.09-1.429-0.683-2.761-1.703-3.782c-1.021-1.022-2.354-1.614-3.787-1.703l0.938-0.931l0.002-0.002
                                                    C24.11,2.403,25.085,2,26.121,2s2.01,0.403,2.741,1.136C29.596,3.869,30,4.843,30,5.878C30,6.915,29.598,7.889,28.862,8.621z
                                                    M22.293,8.293l-10,10c-0.391,0.391-0.391,1.023,0,1.414C12.487,19.902,12.744,20,13,20s0.511-0.098,0.707-0.293l10-10
                                                    c0.391-0.391,0.391-1.023,0-1.414C23.315,7.902,22.684,7.902,22.293,8.293z"/>
                                        </svg>
                                    </a>
                                    <a href="{{route('post.delete',['postId'=>$post['id']])}}">
                                        <svg  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            width="25px" height="25px" viewBox="0 0 774.266 774.266" style="enable-background:new 0 0 774.266 774.266;"
                                            xml:space="preserve">
                                            <path d="M640.35,91.169H536.971V23.991C536.971,10.469,526.064,0,512.543,0c-1.312,0-2.187,0.438-2.614,0.875
                                                C509.491,0.438,508.616,0,508.179,0H265.212h-1.74h-1.75c-13.521,0-23.99,10.469-23.99,23.991v67.179H133.916
                                                c-29.667,0-52.783,23.116-52.783,52.783v38.387v47.981h45.803v491.6c0,29.668,22.679,52.346,52.346,52.346h415.703
                                                c29.667,0,52.782-22.678,52.782-52.346v-491.6h45.366v-47.981v-38.387C693.133,114.286,670.008,91.169,640.35,91.169z
                                                M285.713,47.981h202.84v43.188h-202.84V47.981z M599.349,721.922c0,3.061-1.312,4.363-4.364,4.363H179.282
                                                c-3.052,0-4.364-1.303-4.364-4.363V230.32h424.431V721.922z M644.715,182.339H129.551v-38.387c0-3.053,1.312-4.802,4.364-4.802
                                                H640.35c3.053,0,4.365,1.749,4.365,4.802V182.339z"/>
                                            <rect x="475.031" y="286.593" width="48.418" height="396.942"/>
                                            <rect x="363.361" y="286.593" width="48.418" height="396.942"/>
                                            <rect x="251.69" y="286.593" width="48.418" height="396.942"/>
                                        </svg>
                                    </a>
                                
                                </div>
                            @endif    
                            </div>                           
                        @endforeach
                        <div class="pagination-post">
                        @if (count($posts))
                        {{ $posts->render() }}
                        @endif
                        </div>
                    @else
                        @if($blogOwner)
                        <div class="view-blog div-post paper-material ">
                            <a class="link-post" href="http://localhost/Week8/BlogPage/public/post/create/{{$blogId}}">
                                <h2 class = "post-title">Create Your First Post</h2>
                            </a>
                        </div>
                        @else
                            <div class="view-blog div-post paper-material ">
                            <a class="link-post" href="">
                                <h2 class = "post-title">This Blog is Empty</h2>
                            </a>
                        </div>
                        @endif
                    @endif
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection