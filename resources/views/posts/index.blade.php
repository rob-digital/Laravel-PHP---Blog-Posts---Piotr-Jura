@extends('layout')

@section('content')
    <h2 class="label text-center">Your Blog Posts</h2>
    @forelse ($posts as $post)
        <p>
            <h4> {{ $post->title }}</h4>
            <p>
                Added: {{ $post->created_at->diffForHumans() }}<br/>
                by: {{ $post->user->name }}
            </p>

            @if($post->comments_count)
                <p>{{ $post->comments_count }} comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            <a href="{{ route('posts.show', ['post'=> $post->id]) }}" class="btn btn-success">Read More</a>

            @can('update', $post)
            <a href="{{ route('posts.edit', ['post'=> $post->id]) }}" class="btn btn-info">Edit</a>
            @endcan

            @can('delete', $post)
                 <form method="POST"
                  class="fm-inline"
                  action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')

                <input type="submit" value="delete" class="btn btn-danger " />
            </form>
            @endcan


            <hr/>
        </p>

        @empty
        <p>No blog posts yet!</p>
    @endforelse
@endsection
