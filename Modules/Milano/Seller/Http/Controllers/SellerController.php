<?php
namespace Milano\Seller\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milano\Contact\Repositories\SellerRepo;
use Milano\Seller\Models\Seller;

class SellerController extends Controller
{
    public $repo;
    public function __construct(SellerRepo $sellerRepo)
    {
        $this->repo = $sellerRepo;
    }

    public function index()
    {
        $sellers = $this->repo->all();
        $this->authorize('index',  $sellers);
        return view('Sellers::index', compact('sellers'));
    }

    public function create()
    {
        $seller = $this->repo;
//        $sellers = Seller::first() ?? new Seller;
        $this->authorize('create', $seller);
        return view('Sellers::create' , compact('seller'));
    }

    public function store(Request $request, $id)
    {
        $sellers = $this->repo->store($request, $id);
//        $sellers = Seller::first() ?? new Seller;
        $this->authorize('store', $sellers);
        return redirect(route('sellers.index'));
    }

    public function accept($id)
    {
        $sellers = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $sellers);
    }

    public function reject($id)
    {
        $sellers = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $sellers);
    }
}
