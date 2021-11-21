<?php
namespace Milano\Payment\Http\Controllers;
use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milano\Cart\Models\Cart;
use Milano\Order\Models\Order;
use Milano\Order\Repositories\OrderRepo;
use Milano\Payment\Events\PaymentWasSuccessful;
use Milano\Payment\Gateways\Gateway;
use Milano\Payment\Models\Payment;
use Milano\Payment\Models\Transaction;
use Milano\Payment\Repositories\PaymentRepo;
use Milano\Product\Models\Product;
use Milano\User\Models\User;

class PaymentController extends Controller
{
    public $repo;
    public $orderRepo;
    public function __construct(PaymentRepo $paymentRepo,OrderRepo $orderRepo)
    {
        $this->repo = $paymentRepo;
        $this->orderRepo = $orderRepo;
    }

    public function index(Request $request)
    {
        $payments = $this->repo
            ->searchEmail($request->email)
            ->searchAmount($request->amount)
            ->searchInvoiceId($request->invoice_id)
            ->searchAfterDate(dateFromJalali($request->start_date))
            ->searchBeforeDate(dateFromJalali( $request->end_date))->paginate();

        $last30DaysTotal = $this->repo->getLastNDaysTotal(-30);
        $last30DaysBenefit = $this->repo->getLastNDaysSiteBenefit(-30);
        $last30DaysSellerShare = $this->repo->getLastNDaysSellerShare(-30);
        $totalSell = $this->repo->getLastNDaysTotal();
        $totalBenefit = $this->repo->getLastNDaysSiteBenefit();

        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }
        $summery =  $this->repo->getDailySummery($dates);
        $this->authorize("manage", $payments);
        return view("Payment::index", compact("payments", "last30DaysTotal",
            "last30DaysBenefit", "totalSell", "totalBenefit", "last30DaysSellerShare", "summery", "dates"));
    }

    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = Payment::where('ref_num', $request->clientrefid)->first();
        $payment = (new PaymentRepo())->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));
       if (!$payment)
       {
           newFeedback("تراکنش ناموفق", "تراکنش مورد نظر یافت نشد" ,"error");
           return redirect("/");
       }
        $result = $gateway->verify($payment);
        if (is_array($result)){
        newFeedback("عملیات ناموفق", $result['Message'], "error");
       $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);
        }else {
            event(new PaymentWasSuccessful($payment));
            newFeedback("عملیات موفق", "پرداخت با موفقیت انجام شد.", "success");
            $cart=Cart::find($payment->paymentable_id);
            if($cart)
            {
            foreach($cart->products as $item)
               {
                $item->stock=$item->stock-$item->pivot->count;
                $item->save();
               }
            }
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);
            Auth::user()->carts()->delete();
        }
        return redirect('/');
    }

    public function purchases()
    {
        $orders = $this->orderRepo->all();
        $payments = auth()->user()->payments()->with(["paymentable", 'order'])->paginate();
        return view("Payment::purchases", compact("payments","orders"));
    }

    public function details(Payment $payment ,Order $order, Product $product)
    {
        $payments = $this->repo->all();
        $cart = $payment->paymentable;
        $sellersgroup = $cart->products->groupBy('seller_id');
        $sellers =[];
        foreach ($sellersgroup as $key=>$item){
            $seller_share=0;
            $name = User::find($key)->name;
            foreach ($item as $product){
                $k=$product->total_price*($product->seller_share/100);
                $seller_share+=$k;
            }
            $sellers[]=["name"=>$name,"seller_share"=>$seller_share];
        }
        return view('Payment::details' ,compact(['payment',"sellers"]));
    }

}
