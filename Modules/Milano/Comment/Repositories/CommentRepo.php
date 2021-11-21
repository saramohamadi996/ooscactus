<?php

namespace Milano\Comment\Repositories;

use Milano\Comment\Models\Comment;
use Illuminate\Support\Str;

class CommentRepo
{
    private $query;
    public function __construct()
    {
        $this->query = Comment::query();
    }

     public function findByid($id)
    {
        return Comment::findOrFail($id);
    }

    public function searchEmail($email)
    {
        if (!is_null($email)) {
            $this->query->join("users", "comments.user_id", 'users.id')
                ->select("comments.*", "users.email")->where("email", "like", "%" . $email . "%");
        }return $this;
    }

    public function paginate()
    {
        return Comment::latest()->paginate();
    }

    public function getCommentComments($comment)
    {
        return Comment::where('product_id', $comment)
            ->where('confirmation_status', Comment::CONFIRMATION_STATUS_ACCEPTED)
            ->orderBy('number')->get();
    }

    public function findByIdandCommentId( $comment)
    {
        return Comment::where('product_id', $comment)->where('id', $comment)->first();
    }
    public function replyStore($values)
    {
        return Comment::create([
            'body' => $values->body,
            'user_id' => auth()->id(),
            'parent_id' => $values->parent_id,
            'commentable_type' => $values->commentable_type,
            'commentable_id' => $values->commentable_id,
        ]);

    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return Comment::where('id', $id)->update(['confirmation_status'=> $confirmationStatuses]);
    }

    public function accept($id)
    {
        $comment = $this->findByid($id);
        return $comment->update(['confirmation_status' => Comment::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $comment = $this->findByid($id);
        return $comment->update(['confirmation_status' => Comment::CONFIRMATION_STATUS_REJECTED]);
    }
}
