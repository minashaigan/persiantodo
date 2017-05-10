@extends('layouts.master')

@section('content')
    <h1>Todo List <a href="{{ url('/list/create') }}" class="btn btn-primary pull-right btn-sm">Add New Todo</a></h1>
    <hr/>

    @include('partials.flash_notification')

    @if(count($Lists))
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>List Name</th>
                    {{--<th>Completed</th>--}}
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($Lists as $list)
                    <tr>
                        <a href="{{ url('/list/show', $list->id) }}">
                            <td>{{ $list->name }}</td>
                            <td>
                                {!! Form::open(['route' => ['list.destroy', $list->id], 'class' => 'form-inline', 'method' => 'delete']) !!}
                                    {!! Form::hidden('id', $list->id) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                {!! Form::close() !!}
                            </td>
                        </a>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! $Lists->render() !!}
        </div>
    @else
        <div class="text-center">
            <h3>No lists available yet</h3>
            <p><a href="{{ url('/list/create') }}">Create new list</a></p>
        </div>
    @endif
@endsection