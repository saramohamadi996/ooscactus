@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('products.index') }}" title="محصولات ">محصولات </a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="#">لیست محصولات</a>
            <a class="tab__item" href="{{ route('products.create') }}">ایجاد محصول جدید</a>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">

            <div class="bg-white padding-20">
                <div class="t-header-search">

                    <form action="{{route('products.index')}}" method="get" class="">
                    @csrf
                        <div class="t-header-searchbox font-size-13">
                            <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی محصول">
                            <div class="t-header-search-content">

                                <select name="seller_id">
                                    <option value="">انتخاب فروشنده محصول</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>

                                <select name="seller_id">
                                    <option value="">انتخاب فروشنده محصول</option>
                                    @foreach($sellers as $seller)
                                        <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                    @endforeach
                                </select>

                                <input type="text" class="text" name="title" placeholder="نام محصول">
                                <input type="text" class="text" name="code_product" placeholder="کد محصول">
                                <input type="text" class="text" name="priority" value="{{ request("priority") }}" placeholder="ردیف">
                                <input type="text" class="text" name="price" value="{{ request("price") }}" placeholder="قیمت">
                                <button type="submit" class="btn btn-webamooz_net" id="update-profile" >جستجو</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>ردیف</th>
                        <th>عکس</th>
                        <th>عنوان</th>
                        <th>فروشنده</th>
                        <th>قیمت</th>
{{--                        <th>برچسب ها</th>--}}
                        <th>موجودی</th>
                        <th>کد محصول</th>
                        @can(Milano\RolePermissions\Models\Permission::PERMISSION_MANAGE_PRODUCTS)
                        <th>وضعیت</th>
                        <th>وضعیت تایید</th>
                        <th>عملیات</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr role="row" class="">
                            <td><a href="">{{ $product->priority }}</a></td>
                            <td><img width="80px" src="{{ asset('storage/'.$product->image) }}"></td>
                            <td><a href="">{{ $product->title }}</a></td>
                            <td><a href="">{{ $product->seller->name }}</a></td>
                            <td>{{ $product->price }} (تومان)</td>
{{--                            <td><a href="">{{$product->tag_name}}</a></td>--}}
                            <td><a href="">{{$product->stock }}</a></td>
                            <td><a href="">{{$product->code_product }}</a></td>
                            @can(Milano\RolePermissions\Models\Permission::PERMISSION_MANAGE_PRODUCTS)
                                <td><a name="status" class=""
                                       @if($product->status == 1)href="{{route('products.status',[$product->id])}}"
                                       disabled @endif
                                       href="{{route('products.status',[$product->id])}}">
                                        @if($product->status == 1) موجود
                                        @else ناموجود
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <a name="is_enable" class=""
                                       @if($product->is_enabled == 1)href="{{route('products.toggle',[$product->id])}}"
                                       disabled @endif
                                       href="{{route('products.toggle',[$product->id])}}">
                                        @if($product->is_enabled == 1) تایید شده
                                        @else تایید نشده
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    <a class="item-delete mlg-15" title="حذف" href=""
                                       onclick="deleteItem(event, '{{ route('products.destroy', $product->id)}}')">
                                    </a>
                                    <a class="item-edit mlg-15 " title="ویرایش"
                                       href="{{ route('products.edit',  $product->id) }}">
                                    </a>
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


{{--<a  name="is_enable" class="btn btn-primary"--}}
{{--    @if($product->is_enabled == 1)href="{{route('products.toggle',[$product->id])}}" disabled--}}
{{--    @endif  href="{{route('products.toggle',[$product->id])}}">--}}
{{--    @if($product->is_enabled == 1) غیرفعالسازی(بنر فعال است)--}}
{{--    @else فعالسازی(بنر غیر فعال است)--}}
{{--    @endif--}}
{{--</a>--}}
