@extends('layouts.master')

@section('content')

    @include('partials.flash_notification')

    {!! Form::open(['url'=>'/todo/submit_edit',$todo_id , 'class' => 'form-horizontal', 'role' => 'form']) !!}
    <!-- Name Field -->
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::label('name', 'Todo Name', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('name',  $todo->name , ['class' => 'form-control']) !!}
            <span class="help-block text-danger">
                    {{ $errors -> first('name') }}
                </span>
        </div>

    </div>
    <!-- Context Field -->
    <div class="form-group">
        {!! Form::label('context', 'Todo Context', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('context', $todo->context, ['class' => 'form-control']) !!}
        </div>

    </div>
    <!-- Date Field -->
    <div class="form-group">
        {!! Form::label('end_date', 'Todo End date', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::date('end_date', $todo->date, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- Deadline Field -->
    <div class="form-group">
        {!! Form::label('deadline', 'Todo Deadline', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::date('deadline', $todo->deadline, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- rate Field -->
    <div class="form-group">
        {!! Form::label('rate', 'Todo Rate', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::number('rate', $todo->rate, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- File Field -->
    <div class="form-group">
        {!! Form::label('file', 'Todo File', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::file('file', $todo->file, ['class' => 'form-control']) !!}
        </div>

    </div>

    <!-- Submit Button -->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
            {!! Form::submit('Edit Button', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
    {{--<div class="table-responsive">--}}
        {{--<form action="{{url('todo/submit_edit',$todo_id)}}" >--}}
            {{--ToDo Name:<br>--}}
            {{--<input type="text" name="Name" value="{{ $todo->name }}" /><br>--}}
            {{--ToDo Context:<br>--}}
            {{--<input type="text"  name="Context" value="{{ $todo->context }}" /><br>--}}
            {{--ToDo file:<br>--}}
            {{--<input type="file" name="file" value="{{ $todo->file }}" /><br>--}}
            {{--ToDo Deadline:<br>--}}
            {{--<input type="text" name="deadline" value="{{ $todo->date }}" ><br>--}}
            {{--ToDo date Created:<br>--}}
            {{--<input type="text" name="date" value="{{ $todo->created_at }}" disabled="disabled"><br>--}}
            {{--ToDo rate:<br>--}}
            {{--<input type="number" name="rate" value="{{ $todo->rate }}" /><br>--}}
            {{--<input type="submit">--}}
        {{--</form>--}}

    {{--</div>--}}

@endsection