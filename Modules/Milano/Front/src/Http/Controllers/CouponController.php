<?php
namespace App\Http\Controllers\Front;
use App\Cart;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CouponController extends Controller
{
    public function storeCoupon(Request $request)
    {
        try {
            $request->validate([
                'coupon' => 'required|exists:coupons,code'
            ]);
            $coupon = $this->validCoupon($request->coupon);
            if ($coupon->expired_at < Carbon::now()) {
                Alert::error('خطا', 'کد وارد شده منقضی شده است', 'error');
                return back();
            }
            if ($coupon->start_at > Carbon::now()) {
                Alert::error('خطا', ' تخفیف هنوز شروع نشده است', 'error');
                return back();
            }
            if (!is_null($coupon->quantity) && $coupon->quantity <= 0) {
                toast('کد تخفیف قبلا توسط شما استفاده شده است', 'error');
                return back();
            }
            if ($coupon->status !=  'enable') {
                Alert::error('خطا', 'کد تخفیف هنوز فعال نشده است', 'error');
                return back();
            }
            if ($coupon->userUsedCoupons->contains(auth()->id())) {
                toast('کد تخفیف قبلا توسط شما استفاده شده است', 'error');
                return back();
            }
            if ($coupon->users->count()) {
                if (!$coupon->users->contains('id', auth()->id())) {
                    Alert::error('خطا', 'شما مجاز به استفاده از این کد تخفیف نیستید', 'error');
                    return back();
                }
            }
            return $this->addCoupon($coupon->code, $request);
        } catch (\Exception $e) {
            Alert::error('خطا', 'کد تخفیف وارد شده معتبر نمی باشد', 'error');
            return back();
        }
    }

    public function addCoupon($coupon, $request)
    {
        $cart = Cart::where('id', $request->cart)->firstOrFail();
        $coupon = $this->validCoupon($coupon);

        $price = $cart->total_price;
        $discountP = ($price * $coupon->percent) / 100;
        $totalPrice = $price - $discountP;


        $cart->coupon_id = $coupon->id;
        $cart->final_price = $totalPrice;
        $cart->save();
        toast('کد تخفیف با موفقیت اعمال شد', 'success');
        return back();
    }
    public function validCoupon($coupon)
    {
        return Coupon::where('code', $coupon)->firstOrFail();
    }
}
