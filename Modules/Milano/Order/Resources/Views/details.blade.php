@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('orders.index') }}" title="سفارشات">سفارشات</a></li>
    <li><a href="#" title="جزییات سفارش">جزییات سفارش</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p> نام و نام خانوادگی گیرنده:</p><p>{{$order->name}} </p>
        </div>

        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>موبایل:</p><p>{{$order->mobile}} </p>
        </div>

        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>آدرس گیرنده:</p><p>{{$order->UserAddress}}</p>
        </div>
    </div>
    <br>
<table class="table">
    <thead role="rowgroup">
    <tr role="row" class="title-row">
        <th>ردیف</th>
        <th> کد</th>
        <th> نام </th>
        <th>تعداد </th>
        <th>قیمت(تومان)</th>
        <th>تخفیف</th>
        <th>جمع کل(تومان)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->orderItems as $item)
        <tr role="row" class="">
            <td>{{$item->product_id}}</td>
            <td>{{$item->code_product}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->count}}</td>
            <td>{{$item->price}}</td>
            <td>0</td>
            <td>{{number_format($item->price * $item->count)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection

