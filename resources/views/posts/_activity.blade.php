<div class="container">
    <div class="row">
        {{-- <div class="card" style="width:100%;">
            <div class="card-body">
                <h5 class="card-title">Most Commented</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    What people are currently talking about
                </h6>
            </div>
            <ul class="list-group list-group-flush">
            @foreach ($variable_most_commented as $onePost)
                <li class="list-group-item">{{ $onePost->title }}
                    <a href="{{route('posts.show', ['post' => $post->id])}}"><br>
                        {{ $post->title }}
                    </a>
                </li>
            @endforeach
            </ul>
        </div> --}}

        @component('components.card', [
           'title' => 'Commented',
           'subtitle' => 'What people are currently talking about'
        ])
         @slot('items')
                @foreach ($variable_most_commented as $onePost)
                <li class="list-group-item">
                    <a href="{{route('posts.show', ['post' => $post->id])}}"><br>
                        {{ $onePost->title }}
                    </a>
                </li>
                @endforeach
         @endslot
        @endcomponent

    </div>

    <div class="row mt-4">
        {{-- <div class="card" style="width:100%;">
            <div class="card-body">
                <h5 class="card-title">most Active</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    Users with most posts written
                </h6>
            </div>
            <ul class="list-group list-group-flush">
            @foreach ($variable_most_active_users as $user1)
                <li class="list-group-item">
                   {{ $user1->name }}
                </li>
            @endforeach
            </ul>
        </div> --}}

        @component('components.card', [
            'title' => 'Most Active',
            'subtitle' => 'Users with most posts written'
        ])
            @slot('items', collect($variable_most_active_users)->pluck('name'))
        @endcomponent

    </div>

    <div class="row mt-4">
        {{-- <div class="card" style="width:100%;">
            <div class="card-body">
                <h5 class="card-title">most Active Last Month</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    Users with most posts written in the last month
                </h6>
            </div>
            <ul class="list-group list-group-flush">
            @foreach ($variable_most_active_last_month as $user2)
                <li class="list-group-item">
                   {{ $user2->name }}
                </li>
            @endforeach
            </ul>
        </div> --}}

        @component('components.card', [
            'title' => 'Most Active Last Month',
            'subtitle' => ' Users with most posts written in the last month'
        ])
            @slot('items', collect($variable_most_active_last_month)->pluck('name'))
        @endcomponent

    </div>


</div>
