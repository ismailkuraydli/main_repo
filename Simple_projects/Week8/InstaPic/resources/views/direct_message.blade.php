@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default panel-blog">
                <div class="panel-heading panel-blog page-title"><h1>Send Message to {{$user->name}}</h1></div>
                <div class="panel-body">
    {!! Form::open(array('route'=> ['direct.message',$user->id],'class'=>'form-create')) !!}
        {{ csrf_field() }}

        <div>
        {!! Form::label('content', 'Direct Message:', ['class' => 'input-label']) !!}
        {{$errors->first('content')}}
        <br>
        {!! Form::textarea('content', '',['class'=>'input-textarea','placeholder'=>'Message...']) !!}
        </div>

        <div>
        {!! Form::submit('Send',['class' => 'form-button']) !!}
        </div>


    {!! Form::close() !!}

</div>


            </div>
        </div>
    </div>
</div>
@endsection