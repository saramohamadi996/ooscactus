<?php
namespace Milano\Slideshow\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milano\Setting\Repositories\SettingRepo;
use Milano\Slideshow\Http\Requests\SlideshowRequest;
use Milano\Common\Responses\AjaxResponses;
use Milano\Slideshow\Repositories\SlideshowRepo;

class SlideshowController extends Controller
{
    public $repo;
    public function __construct(SlideshowRepo $slideshowRepo)
    {
        $this->repo = $slideshowRepo;
    }

    public function index()
    {
        $slideshows = $this->repo->paginate();
        $this->authorize('index', $slideshows);
        return view('Slideshows::index', compact('slideshows'));
    }

    public function create()
    {
        return view('Slideshows::create');
    }

     public function store(SlideshowRequest $request)
    {
         $slideshow = $this->repo->store($request);
        $this->authorize('store', $slideshow);
        return redirect(route('slideshows.index'));
    }

    public function edit($id)
    {
        $slideshow = $this->repo->findByid($id);
        $this->authorize('edit', $slideshow);
        return view('Slideshows::edit' , compact('slideshow'));
    }

    public function update($id, Request $request)
    {
        $slideshow = $this->repo->update($request,$id);
        $this->authorize('edit', $slideshow);
        return redirect(route('slideshows.index'));
    }

    public function destroy($id)
    {
        $slideshow = $this->repo->findByid($id);
        $this->authorize( 'delete', $slideshow);
        $slideshow->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $slideshow = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $slideshow);
    }

    public function reject($id)
    {
        $slideshow = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $slideshow);
    }
}
