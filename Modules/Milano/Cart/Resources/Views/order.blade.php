@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('Carts.order') }}" title="سفارشات">سفارشات</a></li>
@endsection
@section('content')

    <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
        <p class="box__title">سفارشات</p>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل </th>
                    <th>موبایل </th>
                    <th>تخفیف</th>
                    <th>جمع کل(تومان)</th>
                    <th>تاریخ و ساعت</th>
                    <th>وضعیت پرداخت</th>
                    <th>وضعیت سفارش</th>
                    <th>وضعیت </th>
                    <th>جزییات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($carts as $cart)
                    <tr role="row" class="">
                        <td><a href="">{{ $cart->id }}</a></td>
                        <td>{{ $cart->user->name }}</td>
                        <td>{{ $cart->user->email }}</td>
                        <td>{{ $cart->user->mobile }}</td>
                        <td>{{ $cart->copon }}</td>
                        <td>{{ number_format($cart->total_price) }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($cart->created_at) }}</td>

                        <td class="@if($cart->status == \Milano\Payment\Models\Payment::STATUS_SUCCESS)
                            text-success @else text-error @endif">@lang($cart->status)</td>
                        <td class="confirmation_status">@lang($cart->order_status)</td>
                        <td>
                           @can(\Milano\RolePermissions\Models\Permission::PERMISSION_MANAGE_PRODUCTS)
                            <a href="" onclick="updateOrderStatus(event, '{{ route('carts.registered', $cart->id) }}'
                                    ,'آیا از تایید این آیتم اطمینان دارید؟' , 'ثبت شده')" class="item-confirm mlg-15" title=""></a>

                                <a href="" onclick="updateOrderStatus(event, '{{ route('carts.preparing', $cart->id) }}',
                                    'آیا از تایید این آیتم اطمینان دارید؟' ,'در حال آماده سازی ')" class="item-preparing mlg-15" title="در حال آماده سازی"></a>

                           <a href="" onclick="updateOrderStatus(event, '{{ route('carts.sent', $cart->id) }}',
                                    'آیا از تایید این آیتم اطمینان دارید؟' ,'ارسال شده')" class="item-sent mlg-15" title="ارسال شده"></a>
                            @endcan
                        </td>
                        <td>
                            <a href="{{ route('carts.details',  $cart->id) }}" class="item-eye mlg-15" title="مشاهده"></a>
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
@endsection
