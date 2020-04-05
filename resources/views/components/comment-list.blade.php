
    @forelse ($comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        {{-- <p class="text-muted">
            added {{ $comment->created_at->format('d-m-Y') }}
        </p> --}}
        @component('components.updated', [
            'date' => $comment->created_at,
            'name' => $comment->user->name,
            'userId' => $comment->user->id,
            ])

        @endcomponent

        {{-- <x-updated
        :date="$post->updated_at"
        >
        Updated
        </x-updated> --}}

    @empty
        <p>No comments yet!</p>
    @endforelse
