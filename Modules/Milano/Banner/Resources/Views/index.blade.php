@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('banners.index')}}" title="بنر">بنر</a></li>
@endsection
@section('content')
    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{route('banners.index')}}">لیست بنرها</a>
                <a class="tab__item " href="{{route('banners.create')}}">ایجاد بنر جدید</a>
            </div>
        </div>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th class="p-r-90">شناسه</th>
                    <th>تصویر</th>
                    <th>عنوان</th>
                    <th>لینک</th>
                    <th>تاریخ ایجاد</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banners as $banner)
                    <tr role="row" class="">
                        <td><a href="">{{ $banner->id }}</a></td>
                        <td width="80"><img src="{{asset('/storage/' . $banner->image)}}"  width="80"></td>
                        <td><a href="">{{ $banner->title }}</a></td>
                        <td><a href="">{{ $banner->link }}</a></td>
                        <td><a href="">{{$banner->JalaliCreatedAt}}</a></td>
                        <td class="confirmation_status">@lang($banner->confirmation_status)</td>
                        <td>
                            @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_BANNERS)
                                <a href="" onclick="deleteItem(event, '{{ route('banners.destroy', $banner->id) }}')"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('banners.accept', $banner->id) }}'
                                    ,'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('banners.reject', $banner->id) }}',
                                    'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                            @endcan
                            <a href="{{ route('banners.edit',  $banner->id) }}" class="item-edit mlg-15 " title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
