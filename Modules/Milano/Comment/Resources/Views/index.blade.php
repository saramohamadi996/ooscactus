@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{route('comments.index')}}" title="نظرات">نظرات</a></li>
@endsection
@section('content')
    <p class="box__title">نظرات</p>
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="{{ route('comments.index') }}" method="get">
                <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی نظر">
                <div class="t-header-search-content">
                    <input type="text"  class="text" name="body"  placeholder="قسمتی از متن">
                    <input type="text"  class="text" name="email"  placeholder="ایمیل">
                    <input type="submit" class="btn btn-webamooz_net" value="جستجو">
                </div>
            </form>
        </div>
    </div>
    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>شناسه</th>
                <th>ارسال کننده</th>
{{--                <th>کامنت مربوط به </th>--}}
                <th>دیدگاه</th>
                <th>تاریخ</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($comments as $comment)
                <tr role="row">
                    <td>{{$comment->id}}</td>
                    <td><a href="">{{ $comment->user->name }}</a></td>
{{--                    <td><a href="">{{$comment->commentable->title}}</a></td>--}}
                    <td><a href="">{{$comment->JalaliCreatedAt}}</a></td>
                    <td>{{$comment->limitCharBody()}}</td>
                    <td class="confirmation_status">@lang($comment->confirmation_status)</td>
                    <td>
                        @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_COMMENTS)
                        <a href="" onclick="deleteItem(event, '{{ route('comments.destroy', $comment->id) }}')" class="item-delete mlg-15" title="حذف"></a>
                        <a href="" onclick="updateConfirmationStatus(event, '{{ route('comments.accept', $comment->id) }}',
                            'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                        <a href="" onclick="updateConfirmationStatus(event, '{{ route('comments.reject', $comment->id) }}',
                            'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                    <a href="{{ route('comments.details',  $comment->id) }}" class="item-eye mlg-15" title="مشاهده"></a>
                    @endcan
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
