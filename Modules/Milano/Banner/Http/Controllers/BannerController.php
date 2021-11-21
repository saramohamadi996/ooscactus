<?php

namespace Milano\Banner\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milano\Banner\Repositories\BannerRepo;
use Milano\Banner\Http\Requests\BannerRequest;
use Milano\Banner\Models\Banner;
use Milano\Common\Responses\AjaxResponses;

class BannerController extends Controller
{
    public $repo;
    public function __construct(BannerRepo $bannerRepo)
    {
        $this->repo = $bannerRepo;
    }


    public function index()
    {
        $banners = $this->repo->paginate();
        $this->authorize('index', $banners);
        return view('Banners::index', compact('banners'));
    }

    public function create()
    {
        $banners = $this->repo;
        $this->authorize('create', $banners);
        return view('Banners::create');
    }

    public function store(BannerRequest $request)
    {
        $banner = $this->repo->store($request);
        return redirect(route('banners.index'));
    }

    public function edit($i)
    {
        $banner =$this->repo->findByid($id);
        $this->authorize('edit', $banner);
        return view('Banners::edit' , compact('banner'));
    }

    public function update($id, BannerRequest $request)
    {
        $banner = $this->repo->update($request,$id);
        $this->authorize('edit', $banner);
        return redirect(route('banners.index'));
    }

    public function destroy($id)
    {
        $banner = $this->repo->findByid($id);
        $this->authorize('delete', $banner);
        $banner->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $banner = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $banner);
    }

    public function reject($id)
    {
        $banner = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $banner);
    }
}
