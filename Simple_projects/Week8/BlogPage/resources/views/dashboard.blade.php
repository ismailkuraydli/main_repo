@extends('layouts.app')
{{HTML::style('css/styles.css')}}
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-blog">
                <div class="panel-heading page-title"><h1>Dashboard</h1></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!$blogs->isEmpty())
                        @foreach ($blogs as $blog)
                            
                                <div class="view-blog div-blog paper-material">
                                    <div class="blog-title">
                                        <a href="blog/view/{{$blog['id']}}" class="link-blog">
                                            <h2>{{$blog['name']}}</h2>
                                        </a>
                                    </div>
                                    <p class = "blog-description">{{$blog['description']}}</p>
                                </div>
                           
                            
                        @endforeach
                        <div class="pagination-post">
                        @if (count($blogs))
                        {{ $blogs->render() }}
                        @endif
                        </div>
                    @else 

                        <div class="view-blog div-post paper-material">
                            <div class="post-title">
                                <a href="{{ route('blog/create') }}" class="link-post">
                                    <h2>Create Your First Blog</h2>
                                </a>
                            </div>
                        </div>   
                    @endif
                     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
