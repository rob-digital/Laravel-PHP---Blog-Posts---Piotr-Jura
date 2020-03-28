@extends('layout')

@section('content')
    <h2 class="mb-3">{{ $post->title }}</h2>
    <h3 class="mb-3">{{ $post->content }}</h3>
    <p>Added: {{ $post->created_at->format('d-m-Y') }}</p>
    <p>Added: {{ $post->created_at->diffForHumans() }}</p>
    <br/>
    <h4>Comments</h4>

    @forelse ($post->comments as $comment)
         <p>
            {{ $comment->content }}
        </p>
        <p class="text-muted">
            added {{ $comment->created_at->format('d-m-Y') }}
        </p>
    @empty
        <p>No comments yet!</p>
    @endforelse

    <hr/>

    @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5 )
        New POST!
    @endif

@endsection
