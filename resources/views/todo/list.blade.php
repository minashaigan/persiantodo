@extends('layouts.master')

@section('content')
    <h1>Todo List <a href="{{ url('/todo/create',$todoList[0]->listt->id) }}" class="btn btn-primary pull-right btn-sm">Add New Todo</a></h1>
    {{--<h1>Todo List <a href="{{ route('todo.show',$todoList[0]->listt->id) }}" class="btn btn-primary pull-right btn-sm">Add New Todo</a></h1>--}}
    <hr/>

    @include('partials.flash_notification')

    @if(count($todoList))
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>ToDo Name</th>
                    <th>Completed</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @if($todoList)
                    @foreach($todoList as $todo)
                        <tr>
                            <td><a href="{{ url('todo/info',$todo->id) }}">{{ $todo->name }}</a></td>
                            <td>{{ $todo->complete? 'Completed' : 'Pending' }}</td>
                            <td>
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
                            </td>
                        </tr>
                    @endforeach
                @else

                @endif

                </tbody>
            </table>
        </div>
        <div class="text-center">
            {{--{!! $todoList->render() !!}--}}
        </div>
    @else
        <div class="text-center">
            <h3>No todos available yet</h3>
            <p><a href="{{ url('/todo/create') }}">Create new todo</a></p>
        </div>
    @endif
@endsection