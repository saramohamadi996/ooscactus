<?php
namespace Milano\Baner\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milano\Baner\Repositories\BanerRepo;
use Milano\Baner\Http\Requests\BanerRequest;
use Milano\Baner\Models\Baner;
use Milano\Common\Responses\AjaxResponses;

class BanerController extends Controller
{
    public $repo;
    public function __construct(BanerRepo $banerRepo)
    {
        $this->repo = $banerRepo;
    }

    public function index()
    {
        $baners = $this->repo->paginate();
        $this->authorize('index', $baners);
        return view('Baners::index', compact('baners'));
    }

    public function create()
    {
        $baners = $this->repo;
        $this->authorize('create', $baners);
        return view('Baners::create');
    }

    public function store(BanerRequest $request)
    {
        $baner = $this->repo->store($request);
        return redirect(route('baners.index'));
    }

    public function edit($id)
    {
        $baner = $this->repo->findByid($id);
        $this->authorize('edit', $baner);
        return view('Baners::edit' , compact('baner'));
    }

    public function update($id, BanerRequest $request)
    {
        $baner = $this->repo->update($request, $id);
        $this->authorize('edit', $baner);
        return redirect(route('baners.index'));
    }

    public function destroy($id)
    {
        $baner = $this->repo->findByid($id);
        $this->authorize('delete', $baner);
        $baner->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $baner = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $baner);
    }

    public function reject($id)
    {
        $baner = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $baner);
    }
}
