<?php
namespace Milano\Coupon\Repositories;
use Milano\Coupon\Models\Coupon;
use Illuminate\Support\Str;

class CouponRepo
{
    private $query;
    public function __construct()
    {
        $this->query = Coupon::query();
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function findByid($id)
    {
        return Coupon::findOrFail($id);
    }

    public function store( $values)
    {
        return Coupon::create([
        'title' => $values->title,
        'code' => $values->code,
            'is_general' => $values->is_general,
            'percent' => $values->percent,
        'limit' => $values->limit,
        'quantity' => $values->quantity,
        'start_at' => $values->start_at,
        'expired_at' => $values->expired_at,
        ]);
    }

    public function update( $values , $id)
    {
        $coupon = Coupon::where('id' , $id)->firstOrFail();
        $coupon->update([
            'title' => $values->title,
            'code' => $values->code,
          'is_general' => $values->is_general,
          'percent' => $values->percent,
            'limit' => $values->limit,
            'quantity' => $values->quantity,
            'start_at' => $values->start_at ?? $coupon->start_at,
            'expired_at' => $values->expired_at ?? $coupon->expired,
        ]);
        $coupon->categories()->sync($values->category_id);
        $coupon->users()->sync($values->user_id);
        $coupon->products()->sync($values->product_id);
        return $coupon;
    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return Coupon::where('id', $id)->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function accept($id)
    {
        $coupon = $this->findByid($id);
        return $coupon->update(['confirmation_status' => Coupon::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $coupon = $this->findByid($id);
        return $coupon->update(['confirmation_status' => Coupon::CONFIRMATION_STATUS_REJECTED]);
    }

    public function getCouponsBySellerId(?int $id)
    {
        return Coupon::where('user_id', $id)->get();
    }

    public function PopularCoupons()
    {
        return Coupon::where('confirmation_status', Coupon::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(6)->get();
    }
}
