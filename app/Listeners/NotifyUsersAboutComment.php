<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUserPostWasCommented;
use App\Mail\CommentPostedMarkdown;

use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {

        Mail::to($event->comment->commentable->user)->send(
            new CommentPostedMarkdown($event->comment)
        );

        NotifyUserPostWasCommented::dispatch($event->comment);
    }
}
