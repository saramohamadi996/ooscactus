@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{route('baners.index')}}" title="شبکه های اجتماعی">شبکه های اجتماعی</a></li>
@endsection
@section('content')
    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{route('baners.index')}}">لیست شبکه های اجتماعی</a>
                <a class="tab__item " href="{{route('baners.create')}}">ایجاد شبکه اجتماعی جدید</a>
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
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($baners as $baner)
                    <tr role="row" class="">
                        <td><a href="">{{ $baner->id }}</a></td>
                        <td width="80"><img src="{{asset('/storage/' . $baner->image)}}"  width="80"></td>
                        <td><a href="">{{ $baner->title }}</a></td>
                        <td><a href="">{{ $baner->link }}</a></td>
                        <td class="confirmation_status">@lang($baner->confirmation_status)</td>
                        <td>
                            @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_BANERS)
                                <a href="" onclick="deleteItem(event, '{{ route('baners.destroy', $baner->id) }}')"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('baners.accept', $baner->id) }}'
                                    ,'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('baners.reject', $baner->id) }}',
                                    'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                            @endcan
                            <a href="{{ route('baners.edit',  $baner->id) }}" class="item-edit mlg-15 " title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
