@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
    <h2 class="label text-center">Laravel Blog Posts</h2>
    @forelse ($posts as $post)
        <p>
            <h4>
                @if ($post->trashed())
                    <del>
                @endif
                {{ $post->title }}</h4>
                @if ($post->trashed())
                  </del>
                @endif
            {{-- <p>
                Added: {{ $post->created_at->diffForHumans() }}<br/>
                by: {{ $post->user->name }}
            </p> --}}

            @component('components.updated', ['name' => $post->user->name, 'date' => $post->created_at])

            @endcomponent

            @component('components.tags', ['my_tags' => $post->tags])

            @endcomponent

            @if($post->comments_count)
                <p>{{ $post->comments_count }} comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            <a href="{{ route('posts.show', ['post'=> $post->id]) }}" class="btn btn-success">Read More</a>

            @auth
                @can('update', $post)
                <a href="{{ route('posts.edit', ['post'=> $post->id]) }}" class="btn btn-info">Edit</a>
                @endcan
            @endauth

            @auth
                @if (!$post->trashed())
                    @can('delete', $post)
                        <form method="POST"
                        class="fm-inline"
                        action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                        @csrf
                        @method('DELETE')

                        <input type="submit" value="delete" class="btn btn-danger " />
                    </form>
                    @endcan
                @endif
            @endauth
            <hr/>
        </p>

        @empty
        <p>No blog posts yet!</p>
    @endforelse
    </div>

    <div class="col-4">
        @include('posts._activity');
    </div>

</div>
@endsection
