<?php

namespace Milano\Comment\Http\Requests;

use Milano\Comment\Rules\ApprovedComment;
use Milano\Comment\Rules\CommentableRule;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "body" => "required",
            "commentable_id" => "required",
            "comment_id" => ["nullable", new ApprovedComment()],
            "commentable_type" => ["required", new CommentableRule()],
        ];
    }
}
