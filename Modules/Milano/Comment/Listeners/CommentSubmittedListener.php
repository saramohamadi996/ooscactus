<?php

namespace Milano\Comment\Listeners;

use Milano\Comment\Notifications\CommentSubmittedNotification;

class CommentSubmittedListener
{
    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        // notify seller
        if ($event->comment->user_id !== $event->comment->commentable->seller->id)
            $event->comment->commentable->seller->notify(new CommentSubmittedNotification($event->comment));

        // notify comment owner
        if ($event->comment->comment_id && $event->comment->user_id !== $event->comment->comment->user->id)
        $event->comment->comment->user->notify(new CommentSubmittedNotification($event->comment));
    }
}
