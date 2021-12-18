@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('Carts.order') }}" title="سفارشات">سفارشات</a></li>
    <li><a href="#" title="جزییات سفارش">جزییات سفارش</a></li>
@endsection
@section('content')
<table class="table">
    <thead role="rowgroup">
    <tr role="row" class="title-row">
        <th>نام و نام خانوادگی</th>
        <th>موبایل </th>
        <th>محصول </th>
        <th>تخفیف</th>
        <th>جمع کل(تومان)</th>
        <th>آدرس</th>
    </tr>
    </thead>
    <tbody>
    @foreach($carts as $cart)
        <tr role="row" class="">
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection

