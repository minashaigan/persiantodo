@extends('layouts.master')

@section('content')

    @include('partials.flash_notification')

    <div class="table-responsive">
        <h1>{{ $list->name }}</h1>


        <h3>date created</h3><p>{{ $list->created_at }}</p>


    </div>

@endsection