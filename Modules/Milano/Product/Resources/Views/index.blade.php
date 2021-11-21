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
                    <form action="">
                        <div class="t-header-searchbox font-size-13">
                            <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی محصول">
                            <div class="t-header-search-content">
                                <input type="text"  class="text" name="title" value="{{ request("title") }}" placeholder="نام محصول">
                                <input type="text"  class="text" name="code_product" value="{{ request("code_product") }}" placeholder="کد محصول">
                                <input type="text"  class="text" name="priority" value="{{ request("priority") }}" placeholder="ردیف">
                                <input type="text"  class="text" name="price" value="{{ request("price") }}" placeholder="قیمت">
                                <button type="submit" class="btn btn-webamooz_net" >جستجو</button>
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
                        <th>برچسب ها</th>
                        <th>موجودی </th>
                        <th>کد محصول</th>
                        <th>وضعیت</th>
                        <th>takhfif</th>
                        <th>وضعیت تایید</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr role="row" class="">
                            <td><a href="">{{ $product->priority }}</a></td>
                            <td width="80"><img src="{{asset('/storage/' . $product->image)}}"  width="80"></td>
                            <td><a href="">{{ $product->title }}</a></td>
                            <td><a href="">{{ $product->seller->name }}</a></td>
                            <td>{{ $product->price }} (تومان)</td>
                            <td><a href="">{{$product->tag_name}}</a></td>
                            <td><a href="">{{$product->stock }}</a></td>
                            <td><a href="">{{$product->code_product }}</a></td>
                            <td class="status">@lang($product->status)</td>
                            <td>
                                <form method="post" action="{{ route("products.coupon") }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input name="coupon" type="number" value="{{ $product->coupon ?? null }}">
                                    <button type="submit">اعمال تخفیف</button>
                                </form>
                            </td>
                            <td class="confirmation_status">@lang($product->confirmation_status)</td>
                            <td>
                                @can(\Milano\RolePermissions\Models\Permission::PERMISSION_MANAGE_PRODUCTS)
                                    <a href="" onclick="deleteItem(event, '{{ route('products.destroy', $product->id) }}')"
                                       class="item-delete mlg-15" title="حذف"></a>
                                    <a href="" onclick="updateConfirmationStatus(event, '{{ route('products.accept', $product->id) }}',
                                        'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                                    <a href="" onclick="updateConfirmationStatus(event, '{{ route('products.reject', $product->id) }}',
                                        'آیا از رد این آیتم اطمینان دارید؟' ,'رد شده')" class="item-reject mlg-15" title="رد"></a>
                                @endcan
                                <a href="{{ route('products.edit',  $product->id) }}" class="item-edit mlg-15 " title="ویرایش"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
