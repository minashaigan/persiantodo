@extends('layouts.master')

@section('content')

    @include('partials.flash_notification')

    <div class="table-responsive">
        <h1>{{ $todo->name }}</h1>

        <h3>ToDo Context</h3><p>{{ $todo->context }}</p>
        <h3>ToDo file</h3><p>{{ $todo->file }}</p>
        <h3>deadline</h3> <p>{{ $todo->date }}</p>
        <h3>date created</h3><p>{{ $todo->created_at }}</p>
        <h3>rate</h3><p>{{ $todo->rate }}</p>
        <h3>Completed</h3><p>{{ $todo->complete? 'Completed' : 'Pending' }}</p>
        <h3>Action</h3>
        <p>
        {!! Form::open(['route' => ['todo.update', $todo->id], 'class' => 'form-inline', 'method' => 'put']) !!}
        @if($todo->complete)
            {!! Form::submit('Incomplete', ['class' => 'btn btn-info btn-xs']) !!}
        @else
            {!! Form::submit('Complete', ['class' => 'btn btn-success btn-xs']) !!}
        @endif
        {!! Form::close() !!}

        {!! Form::open(['route' => ['todo.destroy', $todo->id], 'class' => 'form-inline', 'method' => 'delete']) !!}
        {!! Form::hidden('id', $todo->id) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}

        <a href="{{ url('todo/edit',$todo->id) }}" class="btn btn-warning btn-xs">Edit</a>
        </p>

    </div>

@endsection