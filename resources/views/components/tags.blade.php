<p>
    @foreach ($my_tags as $one_tag)
            <a href="{{ route('route-name-tags-index', ['tag' => $one_tag->id]) }}"
                class="badge badge-info badge-lg">{{ $one_tag->name }}</a>
    @endforeach
</p>
