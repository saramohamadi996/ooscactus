@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('purchases.index') }}" title="خریدهای من">خریدهای من</a></li>
@endsection
@section('content')
    <div class="table__box">
        <table class="table">
            <thead>
            <tr class="title-row">
                <th>تاریخ پرداخت</th>
                <th>مقدار پرداختی</th>
                <th>کد پیگیری </th>
                <th>وضعیت پرداخت</th>
                <th>وضعیت سفارش</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ createFromCarbon($payment->created_at) }}</td>
                <td>{{ number_format($payment->amount) }} تومان</td>
                <td>{{ $payment->ref_num }}</td>
                <td class="@if($payment->status == \Milano\Payment\Models\Payment::STATUS_SUCCESS)
                    text-success @else text-error @endif">@lang($payment->status)</td>
                    <td>@lang($payment->order->status)</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{$payments->render()}}
    </div>
@endsection
