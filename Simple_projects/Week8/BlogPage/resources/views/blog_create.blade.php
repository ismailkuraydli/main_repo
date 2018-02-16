@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default  panel-blog">
                <div class="panel-heading page-title  panel-blog"><h1>Create New Blog</h1></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif  

                        <div>
                        
                            {!! Form::open(array('route'=> 'blog/create','class'=>'form-create')) !!}
                            {{ csrf_field() }}
                            <div>
                            
                            {!! Form::label('name', 'Blog Name:', ['class' => 'input-text-label']) !!}
                            {{$errors->first('name')}}
                            <br>
                            {!! Form::text('name', '',['class'=>'input-text']) !!}
                            </div>
                            
                            
                            <div>
                            {!! Form::label('description', 'Blog description:', ['class' => 'input-textarea-label']) !!}
                            {{$errors->first('description')}}
                            <br>
                            {!! Form::textarea('description','', ['class'=>'input-textarea']) !!}
                            </div>
                            
                            
                            <div>
                            {!! Form::submit('Create Blog',['class' => 'form-button']) !!}
                            </div>
                            
                            
                            {!! Form::close() !!}

                        </div>      
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
