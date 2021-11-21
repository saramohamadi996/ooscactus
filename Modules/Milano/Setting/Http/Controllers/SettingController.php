<?php
namespace Milano\Setting\Http\Controllers;
use App\Http\Controllers\Controller;
use Milano\Setting\Repositories\SettingRepo;
use Milano\Common\Responses\AjaxResponses;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $Repo;
    public function __construct(SettingRepo  $settingRepo)
    {
        $this->Repo = $settingRepo;
    }

    public function index()
    {
        $settings = $this->Repo->all();
        $this->authorize('index', $settings);
        return view('Settings::index', compact('settings'));
    }

    public function create()
    {
        $settings = $this->Repo->create();
        $this->authorize('create', $settings);
        return view('Settings::create' , compact('settings'));
    }

    public function store(Request $request)
    {
        $settings = $this->Repo->store($request);
        $this->authorize('store', $settings);
        return redirect(route('settings.index'));
    }
}
