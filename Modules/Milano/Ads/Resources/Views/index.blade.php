@extends('Dashboard::master')
@section('breadcrumb')
        <li><a href="{{ route('adss.index') }}" title="تبلیغات ">تبلیغات </a></li>
@endsection
@section('content')
    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('adss.index') }}">لیست تبلیغات</a>
                <a class="tab__item " href="{{ route('adss.create') }}" >ایجاد تبلیغ جدید</a>
            </div>
        </div>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
                    <th>تصویر</th>
                    <th>عنوان</th>
                    <th>صفحه</th>
                    <th>تاریخ انقضا</th>
                    <th>محدودیت باز شدن</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($adss as $ads)
                    <tr role="row" class="">
                        <td><a href="">{{ $ads->id }}</a></td>
                        <td width="80"><img src="{{asset('/storage/' . $ads->image)}}"  width="80"></td>
                        <td><a href="">{{ $ads->title }}</a></td>
                        <td><a href="">@lang( $ads->page)</a></td>
                        <td>{{ $ads->expired_at }}</td>
                        <td><a href="">@lang( $ads->opening )</a></td>
                        <td class="confirmation_status">@lang($ads->confirmation_status)</td>
                        <td>
                            @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_ADSS)
                                <a href="" onclick="deleteItem(event, '{{ route('adss.destroy', $ads->id) }}')"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('adss.accept', $ads->id) }}'
                                    ,'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('adss.reject', $ads->id) }}',
                                    'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                            @endcan
                            <a href="{{ route('adss.edit',  $ads->id) }}" class="item-edit mlg-15 " title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

