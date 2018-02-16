@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default  panel-blog">
                <div class="panel-heading page-title"><h1>Edit Post</h1></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                          <div>
                            {!! Form::open(array('route'=> ['post.edit',$post['id']])) !!}
                                {{ csrf_field() }}
                            <div>
                                {!! Form::label('title', 'Post Title:', ['class' => 'input-text-label']) !!}
                                {{$errors->first('title')}}
                                <br>
                                {!! Form::text('title', $post['title'],['class'=>'input-text']) !!}
                                
                            </div>  
                            
                            <div>
                            {!! Form::label('body', 'Post Body:', ['class' => 'input-textarea-label']) !!}
                            {{$errors->first('body')}}
                            <br>
                            {!! Form::textarea('body', $post['body'],['class'=>'input-textarea']) !!}
                            </div>
                            
                            
                            <div>
                            {!! Form::label('tags', 'Post Tags:', ['class' => 'input-text-label']) !!}
                            {{$errors->first('tags')}}
                            <br>
                            {!! Form::text('tags', $post['tags'],['class'=>'input-text']) !!}
                            </div>
                            
                            <div>
                            {!! Form::label('image', 'Image URL:', ['class' => 'input-text-label']) !!}
                            {{$errors->first('image')}}
                            <br>
                            {!! Form::text('image', $post['image'],['class'=>'input-text']) !!}
                            </div>
                            
                            <div>
                            {!! Form::submit('Update Post',['class' => 'form-button']) !!}
                            </div>
                            
                            
                            {!! Form::close() !!}
                          
                          </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
