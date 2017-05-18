@extends('layouts.master')

@section('content')

    @include('partials.flash_notification')

    <div class="table-responsive">
        <form action="{{url('list/edited',$list_id)}}" >
            ToDo Name:<br>
            <input type="text" name="Name" value="{{ $list->name }}" /><br>
            ToDo date Created:<br>
            <input type="text" name="date" value="{{ $list->created_at }}" disabled="disabled"><br>

            <input type="submit">
        </form>

    </div>

@endsection