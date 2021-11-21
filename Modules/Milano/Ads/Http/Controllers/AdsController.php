<?php
namespace Milano\Ads\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milano\Ads\Http\Requests\AdsRequest;
//use Milano\Ads\Models\ImageAds;
//use Milano\Ads\Models\Ads;
use Illuminate\Support\Facades\Storage;
use Milano\Ads\Repositories\AdsRepo;
use Milano\Common\Responses\AjaxResponses;

class AdsController extends Controller
{
    public $repo;
    public function __construct(AdsRepo $adsRepo)
    {
        $this->repo = $adsRepo;
    }

    public function index()
    {
        $adss = $this->repo->paginate();
        $this->authorize('index', $adss);
        return view('Adss::index', compact('adss'));
    }

    public function create()
    {
        $adss = $this->repo;
        $this->authorize('create', $adss);
        return view('Adss::create');
    }

    public function store(AdsRequest $request)
    {
        $adss = $this->repo;
        $adss = $this->repo->store($request);
        return redirect(route('adss.index'));
    }

    public function edit($id)
    {
        $adss =$this->repo->findByid($id);
        $this->authorize('edit', $adss);
        return view('Adss::edit', compact('adss'));
    }

    public function update($id, AdsRequest $request)
    {
        $adss = $this->repo->update($request,$id);
        $this->authorize('edit', $adss);
        return redirect(route('adss.index'));
    }

    public function destroy($id)
    {
        $ads = $this->repo->findByid($id);
        $this->authorize('delete', $ads);
        $ads->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $adss = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $adss);
    }

    public function reject($id)
    {
        $adss = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $adss);
    }
}
