@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{route('coupons.index')}}" title="تخفیف">تخفیف</a></li>
@endsection
@section('content')
    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{route('coupons.index')}}">لیست تخفیف ها</a>
                <a class="tab__item " href="{{route('coupons.create')}}">ایجاد تخفیف  جدید</a>
            </div>
        </div>
        <div class="table__box">
            <div class="table-box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>عنوان </th>
                        <th>کد </th>
                        <th>درصد</th>
                        <th>مقدار </th>
                        <th> نوع </th>
                        <th>وضعیت</th>
                        <th> تعداد</th>
                        <th> پایان</th>
                        <th>وضعیت تخفیف</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="">
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->title }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->percent }}  درصد</td>
                            <td>{{ number_format($coupon->limit) }} تومان</td>
                            <td>@if ($coupon->is_general == 0)<b>عمومی</b>@else<b>اختصاصی</b>@endif</td>
                            <td>{{ $coupon->quantity }} عدد </td>
                            <td>{{ $coupon->expired_at }}</td>
                            <td class="confirmation_status">@lang($coupon->confirmation_status)</td>
                            <td>
                                @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_COUPONS)
                                    <a href="" onclick="deleteItem(event, '{{ route('coupons.destroy', $coupon->id) }}')"
                                       class="item-delete mlg-15" title="حذف"></a>
                                    <a href="" onclick="updateConfirmationStatus(event, '{{ route('coupons.accept', $coupon->id) }}'
                                        ,'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                                    <a href="" onclick="updateConfirmationStatus(event, '{{ route('coupons.reject', $coupon->id) }}',
                                        'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                                @endcan
                                <a href="{{ route('coupons.edit',  $coupon->id) }}" class="item-edit mlg-15 " title="ویرایش"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
