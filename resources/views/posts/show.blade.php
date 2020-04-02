@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
            <h2 class="mb-3">
                {{ $post->title }}

                    @component('components.badge', ['show' => now()->diffInMinutes($post->created_at) < 10])
                            Super New POST
                    @endcomponent


            </h2>
            <h3 class="mb-3">{{ $post->content }}</h3>
                @component('components.updated', ['name' => $post->user->name, 'date' => $post->created_at])

                @endcomponent
                @component('components.updated', [ 'date' => $post->created_at])
                    Updated
                @endcomponent

                @component('components.tags', ['my_tags' => $post->tags])@endcomponent

                <p>Currently read by {{ $counter }} people</p>

                @component('components.badge', ['type' => 'danger'])
                        AD
                @endcomponent
            <p>Added: {{ $post->created_at->diffForHumans() }}</p>
            <br/>
            <h4>Comments</h4>

            @forelse ($post->comments as $comment)
                <p>
                    {{ $comment->content }}
                </p>
                {{-- <p class="text-muted">
                    added {{ $comment->created_at->format('d-m-Y') }}
                </p> --}}
                @component('components.updated', [ 'date' => $comment->created_at])

                @endcomponent
            @empty
                <p>No comments yet!</p>
            @endforelse

            <hr/>

            @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 10 )


            @endif
    </div>

    <div class="col-4">
        @include('posts._activity')
    </div>

</div>
@endsection
