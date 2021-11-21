@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{route('sellers.index')}}" title="همکاری با ما">همکاری با  ما</a></li>
@endsection
@section('content')
<div class="main-content font-size-13">
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item " href="{{route('sellers.create')}}">ویرایش اطلاعات</a>
        </div>
    </div>
    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>درصد</th>
                <th>سهم سایت</th>
                <th> قیمت گذاری</th>
                <th> قیمت</th>
                <th>تسویه حساب</th>
                <th>تسویه</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sellers as $seller)
                <tr role="row" class="">
                    <td width="80"><img src="{{asset('/storage/' . $seller->image1)}}"  width="80"></td>
                    <td><a href="">{{ $seller->title1 }}</a></td>
                    <td width="80"><img src="{{asset('/storage/' . $seller->image2)}}"  width="80"></td>
                    <td><a href="">{{ $seller->title2}}</a></td>
                    <td width="80"><img src="{{asset('/storage/' . $seller->image3)}}"  width="80"></td>
                    <td><a href="">{{ $seller->title3}}</a></td>
                    <td class="confirmation_status">@lang($seller->confirmation_status)</td>
                    <td>
                        @can(\Milano\RolePermissions\Models\Permission::PERMISSION_MANAGE_SELLERS)
                            <a href="" onclick="updateConfirmationStatus(event, '{{ route('sellers.accept', $seller->id) }}',
                                'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                            <a href="" onclick="updateConfirmationStatus(event, '{{ route('sellers.reject', $seller->id) }}',
                                'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
