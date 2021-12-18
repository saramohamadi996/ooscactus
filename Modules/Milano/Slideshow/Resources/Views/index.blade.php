@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('slideshows.index')}}" title="اسلاید">اسلاید</a></li>
@endsection
@section('content')
<div class="main-content font-size-13">
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="{{route('slideshows.index')}}">لیست اسلایدها</a>
            <a class="tab__item " href="{{route('slideshows.create')}}">ایجاد اسلاید جدید</a>
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
            @foreach($slideshows as $slideshow)
                <tr role="row" class="">
                    <td><a href="">{{ $slideshow->id }}</a></td>
                    <td width="80"><img src="{{asset('/storage/' . $slideshow->image)}}" width="80"></td>
                    <td><a href="">{{ $slideshow->title }}</a></td>
                    <td><a href="">{{ $slideshow->link }}</a></td>
                    <td><a href="">{{$slideshow->JalaliCreatedAt}}</a></td>
                    <td class="confirmation_status">@lang($slideshow->confirmation_status)</td>
                    <td>
                        @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_SLIDESHOWS)
                            <a href="" onclick="deleteItem(event, '{{ route('slideshows.destroy', $slideshow->id) }}')"
                               class="item-delete mlg-15" title="حذف"></a>
                            <a href="" onclick="updateConfirmationStatus(event, '{{ route('slideshows.accept', $slideshow->id) }}'
                                ,'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                            <a href="" onclick="updateConfirmationStatus(event, '{{ route('slideshows.reject', $slideshow->id) }}',
                                'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                        @endcan
                        <a href="{{ route('slideshows.edit',  $slideshow->id) }}" class="item-edit mlg-15 " title="ویرایش"></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
