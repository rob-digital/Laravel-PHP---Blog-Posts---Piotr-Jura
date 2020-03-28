@extends('layout')

@section('content')
    <h2 class="label text-center">Your Blog Posts</h2>
    @forelse ($posts as $post)
        <p>
            <h4> {{ $post->title }}</h4>

            @if($post->comments_count)
                <p>{{ $post->comments_count }} comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            <a href="{{ route('posts.show', ['post'=> $post->id]) }}" class="btn btn-success">Read More</a>
            <a href="{{ route('posts.edit', ['post'=> $post->id]) }}" class="btn btn-info">Edit</a>

            <form method="POST"
                  class="fm-inline"
                  action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')

                <input type="submit" value="delete" class="btn btn-danger " />
            </form>

            <hr/>
        </p>

        @empty
        <p>No blog posts yet!</p>
    @endforelse
@endsection
