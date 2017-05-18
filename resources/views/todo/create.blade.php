@extends('layouts.master')

@section('content')
    <h1>Create New Todo</h1>
    <hr/>

    {!! Form::open(['url' => '/todo',$list_id , 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <!-- Name Field -->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Todo Name', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                <span class="help-block text-danger">
                    {{ $errors -> first('name') }}
                </span>
            </div>

        </div>
        <!-- Context Field -->
        <div class="form-group">
            {!! Form::label('context', 'Todo Context', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('context', null, ['class' => 'form-control']) !!}
            </div>

        </div>
        <!-- Date Field -->
        <div class="form-group">
            {!! Form::label('end_date', 'Todo End date', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!-- Deadline Field -->
        <div class="form-group">
            {!! Form::label('deadline', 'Todo Deadline', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::date('deadline', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!-- rate Field -->
        <div class="form-group">
            {!! Form::label('rate', 'Todo Rate', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::number('rate', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!-- File Field -->
        <div class="form-group">
            {!! Form::label('file', 'Todo File', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::file('file', null, ['class' => 'form-control']) !!}
            </div>

        </div>
        <input type="hidden" name="list_id" value="{{$list_id}}">
        <!-- Submit Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                {!! Form::submit('Create Button', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
@endsection