@extends('layout')

@section('content')
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        @include('posts._form')

        <button type="submit" class="btn btn-success">Create!</button>
    </form>
@endsection
