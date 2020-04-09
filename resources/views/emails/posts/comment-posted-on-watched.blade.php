@component('mail::message')
# Comment was posted on post you're watching

<p>Hi {{ $user->name }}</p>

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

@component('mail::image')

@endcomponent

!['alt_tag']({{Storage::url('/avatars/image36.png')}})
Thanks,<br>
{{ config('app.name') }}
@endcomponent
