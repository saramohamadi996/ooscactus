@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('articles.index') }}" title="مقالات ">مقالات </a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="articles.html">لیست مقالات</a>
            <a href="{{ route('articles.create') }}" title="ایجاد مقاله جدید">ایجاد مقاله جدید</a>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <div class="bg-white padding-20">
                <div class="t-header-search">
                    <form action="">
                        <div class="t-header-searchbox font-size-13">
                            <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی مقاله">
                            <div class="t-header-search-content ">
                                <input type="text" class="text" name="title" value="{{ request("title") }}"
                                       placeholder="نام مقاله">
                                <input type="text" class="text margin-bottom-20" name="category_id"
                                       value="{{ request("category_id") }}" placeholder="دسته بندی">
                                <button type="submit" class="btn btn-webamooz_net">جستجو</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>عکس</th>
                        <th>عنوان</th>
                        <th>دسته بندی</th>
                        <th>نویسنده</th>
                        <th>تاریخ</th>
                        <th>بازدید</th>
                        <th>نظرات</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr role="row" class="">
                            <td><a href="">{{ $article->id }}</a></td>
                            <td><img width="80px" src="{{ asset('storage/'.$article->image) }}"></td>
                            <td><a href="">{{ $article->title }}</a></td>
                            <td>@foreach($article->categories as $category){{$category->title}}@endforeach</td>
                            <td><a href="">{{ $article->user->name }}</a></td>
                            <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($article->created_at) }}</td>
                            <td><a href="">{{ $article->viewCount }}</a></td>
                            @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_ARTICLES)

                                <td>
                                    <a name="is_enable" class=""
                                       @if($article->is_enabled == 1)href="{{route('articles.toggle',[$article->id])}}"
                                       disabled @endif
                                       href="{{route('articles.toggle',[$article->id])}}">
                                        @if($article->is_enabled == 1) تایید شده
                                        @else تایید نشده
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    <a href=""
                                       onclick="deleteItem(event, '{{ route('articles.destroy', $article->id) }}')"
                                       class="item-delete mlg-15" title="حذف"></a>
                                    <a href="{{ route('articles.edit',  $article->id) }}" class="item-edit mlg-15 "
                                       title="ویرایش"></a>
                                </td>
                            @endcan
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

