@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-blog">
                <div class="panel-heading panel-blog page-title"><h1>Edit Profile</h1></div>
                <div class="panel-body">
    {!! Form::open(array('route'=> 'post.create','class'=>'form-create','enctype'=>'multipart/form-data')) !!}
        {{ csrf_field() }}
        
        <div>
        {!! Form::label('image', 'Image:', ['class' => 'input-label']) !!}
        {{$errors->first('image')}}
        <br>
        {!! Form::file('image', '',['class'=>'input-file']) !!}
        </div>

        <div>
        {!! Form::label('caption', 'Caption:', ['class' => 'input-label']) !!}
        {{$errors->first('caption')}}
        <br>
        {!! Form::textarea('caption', '',['class'=>'input-textarea','placeholder'=>'Caption...']) !!}
        </div>

        <div>
        {!! Form::submit('Post',['class' => 'form-button']) !!}
        </div>


    {!! Form::close() !!}

</div>


            </div>
        </div>
    </div>
</div>
@endsection