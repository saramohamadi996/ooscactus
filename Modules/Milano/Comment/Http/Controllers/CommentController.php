<?php

namespace Milano\Comment\Http\Controllers;

use Milano\Comment\Events\CommentSubmittedEvent;
use App\Http\Controllers\Controller;
use Milano\Comment\Http\Requests\CommentRequest;
use Milano\Comment\Models\Comment;
use Milano\Comment\Repositories\CommentRepo;
use Milano\Common\Responses\AjaxResponses;
use Milano\Product\Models\Product;
use Milano\RolePermissions\Models\Permission;

class CommentController extends Controller
{

    public function index(CommentRepo $repo)
    {
        $this->authorize('index', Comment::class);
        $comments = $repo
            ->searchBody(request("body"))
            ->searchEmail(request("email"))
            ->searchName(request("name"))
            ->searchStatus(request("status"));
        if (!auth()->user()->hasAnyPermission(Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_SUPER_ADMIN)) {
            $comments->query->whereHasMorph("commentable", [Product::class], function ($query) {
                return $query->where("seller_id", auth()->id());
            })->where("status", Comment::STATUS_APPROVED);
        }
        $comments = $comments->paginateParents();
        return view("Comments::index", compact("comments"));
    }

    public function show($comment)
    {
        $comment = Comment::query()->where("id", $comment)->with("commentable", "user", "comments")->firstOrFail();
        $this->authorize('view', $comment);
        return view("Comments::show", compact("comment"));
    }

    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $comment = $repo->store($request->all());
        event(new CommentSubmittedEvent($comment));
//        newFeedback("عملیات موفقیت آمیز", "دیدگاه شما با ثبت گردید.");
        return back();
    }

    public function accept($id, CommentRepo $commentRepo)
    {
        $this->authorize('manage', Comment::class);
        if ($commentRepo->updateStatus($id, Comment::STATUS_APPROVED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function reject($id, CommentRepo $commentRepo)
    {
        $this->authorize('manage', Comment::class);
        if ($commentRepo->updateStatus($id, Comment::STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function destroy($id, CommentRepo $repo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $repo->findOrFail($id);
        $comment->delete();
        return AjaxResponses::SuccessResponse();
    }
}
