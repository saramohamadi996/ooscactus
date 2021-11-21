@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('orders.index') }}" title="سفارشات">سفارشات</a></li>
@endsection
@section('content')
    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
        <p class="margin-bottom-15">همه سفارشات</p>
        <div class="t-header-search">
            <form action="">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی تراکنش">
                    <div class="t-header-search-content ">
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
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل </th>
                    <th>موبایل </th>
                    <th>تخفیف</th>
                    <th>جمع کل(تومان)</th>
                    <th>تاریخ و ساعت</th>
                    <th> پرداخت</th>
                    <th>وضعیت ارسال </th>
                    <th>وضعیت سفارش</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr role="row" class="">
                        <td><a href="">{{ $order->id }}</a></td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->user->email }}</td>
                        <td>{{ $order->user->mobile }}</td>
                        <td>{{ $order->copon }}0</td>
                        <td>{{ number_format($order->total_price) }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($order->created_at) }}</td>

                        @foreach ($order->payments as $payment)
                            <td class="@if($payment->status == \Milano\Payment\Models\Payment::STATUS_SUCCESS)
                                text-success @else text-error @endif">@lang($payment->status)</td>
                        @endforeach
                        <td class="status">@lang($order->status)</td>
                        <td>@can(\Milano\RolePermissions\Models\Permission::PERMISSION_MANAGE_PRODUCTS)
                                <a href="" onclick="updateOrderStatus(event, '{{ route('orders.preparing', $order->id) }}',
                                    'آیا از تایید این آیتم اطمینان دارید؟' ,'در حال آماده سازی ' , 'status')" class="item-preparing mlg-15" title="در حال آماده سازی"></a>
                           <a href="" onclick="updateOrderStatus(event, '{{ route('orders.sent', $order->id) }}',
                                    'آیا از تایید این آیتم اطمینان دارید؟' ,'ارسال شد', 'status')" class="item-sent mlg-15" title="ارسال شد"></a>
                            @endcan
                        <a href="{{ route('orders.details', $order->id) }}" class="item-eye mlg-15" title="مشاهده"></a>
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
