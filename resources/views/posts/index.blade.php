@extends('layout')

@section('content')
    <h2 class="label text-center">Your Blog Posts</h2>
    @foreach ($posts as $post)
        <p>
            <h4> {{ $post->title }}</h4>
            <a href="{{ route('posts.show', ['post'=> $post->id]) }}" class="btn btn-success">Read More</a>
            <a href="{{ route('posts.edit', ['post'=> $post->id]) }}" class="btn btn-info">Edit</a>

            <form method="POST"
                  class="form-inline"
                  action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')

                <input type="submit" value="delete" class="btn btn-danger" />
            </form>

            <hr/>
        </p>
    @endforeach
@endsection
