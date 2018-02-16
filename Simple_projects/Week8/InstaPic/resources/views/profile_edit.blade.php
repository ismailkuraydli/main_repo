@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-blog">
                <div class="panel-heading panel-blog page-title"><h1>Edit Profile</h1></div>
                <div class="panel-body">
    {!! Form::open(array('route'=> 'profile.edit','class'=>'form-create','enctype'=>'multipart/form-data')) !!}
        {{ csrf_field() }}
        
        <div>
        {!! Form::label('avatar', 'Profile Picture:', ['class' => 'input-label']) !!}
        {{$errors->first('avatar')}}
        <br>
        {!! Form::file('avatar', '',['class'=>'input-file']) !!}
        </div>

        <div>
        {!! Form::label('cover', 'Cover Picture:', ['class' => 'input-label']) !!}
        {{$errors->first('cover')}}
        <br>
        {!! Form::file('cover', '',['class'=>'input-file']) !!}
        </div>

        <div>
        {!! Form::label('displayname', 'displayname:', ['class' => 'input-label']) !!}
        {{$errors->first('caption')}}
        <br>
        {!! Form::text('displayname', $user->displayname,['class'=>'input-file']) !!}
        </div>

        <div>
        {!! Form::label('website', 'Website:', ['class' => 'input-label']) !!}
        {{$errors->first('website')}}
        <br>
        {!! Form::text('website', $user->website,['class'=>'input-file']) !!}
        </div>
        
        <div>
        {!! Form::label('gender', 'gender:', ['class' => 'input-label']) !!}
        {{$errors->first('gender')}}
        <br>
        {!! Form::text('gender', $user->gender,['class'=>'input-file']) !!}
        </div>

        <div>
        {!! Form::label('mobile', 'Mobile Number:', ['class' => 'input-label']) !!}
        {{$errors->first('mobile')}}
        <br>
        {!! Form::tel('mobile', $user->mobile,['class'=>'input-file']) !!}
        </div>
        <div>
        {!! Form::label('bio', 'Biography:', ['class' => 'input-label']) !!}
        {{$errors->first('bio')}}
        <br>
        {!! Form::textarea('bio', $user->bio,['class'=>'input-file']) !!}
        </div>

        <div>
        {!! Form::submit('Save Changes',['class' => 'form-button']) !!}
        </div>


    {!! Form::close() !!}

</div>


            </div>
        </div>
    </div>
</div>
@endsection