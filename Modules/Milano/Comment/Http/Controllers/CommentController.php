<?php
namespace Milano\Comment\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milano\Comment\Http\Requests\CommentRequest;
use Milano\Comment\Repositories\CommentRepo;
use Milano\Common\Responses\AjaxResponses;

class CommentController extends Controller
{
    public $repo;
    public function __construct(CommentRepo $commentRepo)
    {
        $this->repo = $commentRepo;
    }

    public function index(Request $request)
    {
        $comments = $this->repo->searchEmail
        ($request->email)->paginate();
        $this->authorize('index', $comments);
        return view('Comments::index' , compact('comments'));
    }

    public function details($id)
    {
        $comment = $this->repo->findByid($id);
        $this->authorize('details', $comment);
        return view('Comments::details', compact('comment'));
    }

    public function update($id, CommentRequest $request)
    {
        $comment = $commentRepo->update(['body' => $request->body] ,$id);
        $this->authorize('edit', $comment);
        return redirect(route('comments.index'));
    }

    public function reply($id)
    {
        $comment = $this->repo->findByid($id);
        $this->authorize('answer' , $comments);
        return view('comments.reply' , compact('comment'));
    }

    public function replyStore(Request $request)
    {
        $comment = $this->repo->replyStore($request);
        $this->authorize('answer',$comment );
        return redirect(route('comments.index'));
    }

    public function destroy($id)
    {
        $comment = $this->repo->findByid($id);
        $this->authorize('delete', $comment);
        $comment->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $comment = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $comment);
    }

    public function reject($id)
    {
        $comment = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $comment);
    }
}
