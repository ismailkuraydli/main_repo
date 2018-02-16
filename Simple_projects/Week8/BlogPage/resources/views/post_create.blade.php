@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-blog">
                <div class="panel-heading panel-blog page-title"><h1>Create New Post</h1></div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors)
                        @foreach ($errors->all() as $error)
                            {{$error}}
                        @endforeach
                    @endif

                        
                        <div>
                        {!! Form::open(array('route'=> ['post.create',$blogId],'class'=>'form-create')) !!}
                            {{ csrf_field() }}
                            <div>
                            {!! Form::label('title', 'Post Title:', ['class' => 'input-text-label']) !!}
                            {{$errors->first('title')}}
                            <br>
                            {!! Form::text('title', '',['class'=>'input-text']) !!}
                            </div>  
                            
                            <div>
                            {!! Form::label('body', 'Post Body:', ['class' => 'input-textarea-label']) !!}
                            {{$errors->first('body')}}
                            <br>
                            {!! Form::textarea('body', '',['class'=>'input-textarea']) !!}
                            </div>
                            
                            
                            <div>
                            {!! Form::label('tags', 'Post Tags:', ['class' => 'input-text-label']) !!}
                            {{$errors->first('tags')}}
                            <br>
                            {!! Form::text('tags', '',['class'=>'input-text']) !!}
                            </div>
                            
                            <div>
                            {!! Form::label('image', 'Image:', ['class' => 'input-text-label']) !!}
                            {{$errors->first('image')}}
                            <br>
                            {!! Form::text('image', '',['class'=>'input-text']) !!}
                            </div>
                        
                            <div>
                            {!! Form::submit('Create Post',['class' => 'form-button']) !!}
                            </div>
                        
                        
                        {!! Form::close() !!}
                        
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
