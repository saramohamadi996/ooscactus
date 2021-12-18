@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('payments.index') }}" title="تراکنش ها">تراکنش ها</a></li>
    <li><a href="#" title="جزییات تراکنش">جزییات تراکنش</a></li>
@endsection
@section('content')
<div class="row no-gutters">
    <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
        <p>شماره فاکتور </p><p>{{$payment->paymentable_id}} </p>
    </div>

    <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
        <p>شماره تراکنش</p><p>{{$payment->invoice_id}} </p>
    </div>

    <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
        <p>سهم فروشنده</p><p>{{ number_format($payment->seller_share) }} تومان</p>
    </div>

    <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
        <p> مبلغ کل </p><p>{{ number_format($payment->amount) }} تومان</p>
    </div>
</div>
<br>
<table class="table">
    <thead role="rowgroup">
    <tr role="row" class="title-row">
        <th>نام فروشنده</th>
        <th>سهم فروشنده</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sellers as $seller)
        <tr role="row" class="">
            <td>{{$seller["name"]}}</td>
            <td>{{ number_format($seller["seller_share"]) }} تومان</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection

