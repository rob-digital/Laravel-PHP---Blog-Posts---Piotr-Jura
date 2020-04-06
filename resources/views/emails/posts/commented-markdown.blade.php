@component('mail::message')
# Comment was posted on your blog post

<p>Hi {{ $comment->commentable->user->name }}</p>

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])  ])
View the blog post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id ]) ])
View {{ $comment->user->name }} profile

@endcomponent
{{-- <img src="{{ $message->embed($comment->user->image->url()) }}" /> --}}
@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
