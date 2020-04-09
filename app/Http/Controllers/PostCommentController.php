<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUserPostWasCommented;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request) {

        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        event(new CommentPosted($comment));

        // Mail::to($post->user)->send(
        //     new CommentPostedMarkdown($comment)
        // );

        // NotifyUserPostWasCommented::dispatch($comment);


        $request->session()->flash('status', 'Comment was created');

        return redirect()->back();
    }
}
