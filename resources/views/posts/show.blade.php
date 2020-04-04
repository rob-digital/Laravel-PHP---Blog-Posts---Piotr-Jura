@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
        @if ($post->image)
        <div style="background-image: url('{{ $post->image->url() }}'); min-height: 300px;  color: white; text-align: center; background-attachment: fixed;">
            <h2 style="padding-top: 100px; text-shadow: 1px 2px #000">
        @else
            <h2 class="mb-3">
        @endif

                {{ $post->title }}

                {{-- @component('components.badge', ['show' => now()->diffInMinutes($post->created_at) < 10])
                        Super New POST
                @endcomponent --}}
                <x-badge
                :show="now()->diffInMinutes($post->created_at) < 10"
                >
                Super New POST
                </x-badge>

            @if ($post->image)
            </h2>
        </div>
            @else
                </h2>
            @endif


            <h3 class="mb-3">{{ $post->content }}</h3>



                @component('components.updated', ['name' => $post->user->name, 'date' => $post->created_at])

                @endcomponent
                {{-- @component('components.updated', [ 'date' => $post->created_at])
                    Updated
                @endcomponent --}}
                <x-updated
                :date="$post->created_at"
                >
                Updated1
                </x-updated>


                @component('components.tags', ['my_tags' => $post->tags])@endcomponent

                <p>Currently read by {{ $counter }} people</p>

                {{-- @component('components.badge', ['type' => 'danger'])
                        AD
                @endcomponent --}}
                <x-badge
                type="danger">
                AD
                </x-badge>
            <p>Added: {{ $post->created_at->diffForHumans() }}</p>
            <br/>
            <h4>Comments</h4>

            @include('comments._form')


            @forelse ($post->comments as $comment)
                <p>
                    {{ $comment->content }}
                </p>
                {{-- <p class="text-muted">
                    added {{ $comment->created_at->format('d-m-Y') }}
                </p> --}}
                @component('components.updated', [ 'date' => $comment->created_at, 'name' => $comment->user->name])

                @endcomponent

                <x-updated
                :date="$post->updated_at"
                >
                Updated
                </x-updated>

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
