@extends('layout')

@section('content')
    <h2>{{ $post->title }}</h2>
    <h3>{{ $post->content }}</h3>
    <p>Added: {{ $post->created_at->format('d-m-Y') }}</p>
    <p>Added: {{ $post->created_at->diffForHumans() }}</p>
    <hr/>

    @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5 )
        New POST!
    @endif

@endsection
