@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('payments.index') }}" title="تراکنش ها">تراکنش ها</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>کل فروش ۳۰ روز گذشته سایت </p>
            <p>{{ number_format($last30DaysTotal) }} تومان</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>درآمد خالص ۳۰ روز گذشته سایت</p>
            <p>{{ number_format($last30DaysBenefit) }} تومان</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>کل فروش سایت</p>
            <p>{{ number_format($totalSell) }} تومان</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
            <p> کل درآمد خالص سایت</p>
            <p>{{ number_format($totalBenefit) }} تومان</p>
        </div>
    </div>
    <div class="row no-gutters border-radius-3 font-size-13">
        <div class="col-12 bg-white padding-30 margin-bottom-20">
            <div id="container"></div>
        </div>
    </div>
    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
        <p class="margin-bottom-15">همه تراکنش ها</p>
        <div class="t-header-search">
            <form action="">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی تراکنش">
                    <div class="t-header-search-content ">
                        <input type="text"  class="text" name="email" value="{{ request("email") }}"  placeholder="ایمیل">
                        <input type="text"  class="text" name="amount"  value="{{ request("amount") }}" placeholder="مبلغ به تومان">
                        <input type="text"  class="text" name="invoice_id" value="{{ request("invoice_id") }}" placeholder="شماره">
                        <input type="text"  class="text" name="start_date" value="{{ request("start_date") }}" placeholder="از تاریخ :">
                        <input type="text" class="text margin-bottom-20" name="end_date" value="{{ request("end_date") }}" placeholder="تا تاریخ :">
                        <button type="submit" class="btn btn-webamooz_net" >جستجو</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
                    <th>کد پیگیری</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل پرداخت کننده</th>
                    <th>موبایل</th>
                    <th>مبلغ (تومان)</th>
                    <th>درآمد فروشنده</th>
                    <th>درآمد سایت</th>
                    <th>تاریخ و ساعت</th>
                    <th>وضعیت</th>
                    <th>جزییات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr role="row" class="">
                        <td><a href="">{{ $payment->id }}</a></td>
                        <td>{{ $payment->ref_num }}</td>
                        <td>{{ $payment->buyer->name }}</td>
                        <td>{{ $payment->buyer->email }}</td>
                        <td>{{ $payment->buyer->mobile }}</td>
                        <td>{{ number_format($payment->amount) }}</td>
                        <td>{{ number_format($payment->seller_share) }}</td>
                        <td>{{ number_format($payment->site_share) }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($payment->created_at) }}</td>
                        <td class="@if($payment->status == \Milano\Payment\Models\Payment::STATUS_SUCCESS) text-success @else text-error @endif">@lang($payment->status)</td>

{{--                        @foreach ($payment->orders as $order)--}}
{{--                            <td class="status">@lang($order->status)</td>--}}
{{--                        @endforeach--}}
                        <td>
                            <a href="{{ route('payments.details',  $payment->id) }}" class="item-eye mlg-15" title="مشاهده"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        @include('Common::layouts.feedbacks')
    </script>
    @include("Payment::chart")
@endsection
