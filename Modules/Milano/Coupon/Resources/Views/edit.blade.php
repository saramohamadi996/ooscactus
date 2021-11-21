@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('coupons.index') }}" title="تخفیف ها">تخفیف ها</a></li>
    <li><a href="#" title="ویرایش تخفیف">ویرایش تخفیف</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">ویرایش تخفیف</p>
            <form action="{{route('coupons.update', $coupon->id)}}" method="post" class="padding-30" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <p class="box__title">وضعیت تخفیف</p>
                <div class="w-50">
                    <div class="notificationGroup">
                        <input id="ads-field-1" class="ads-field-pn" name="is_general" value="0" {{ $coupon->is_general == 0 ? 'checked' : ''  }} type="radio" checked/>
                        <label for="ads-field-1">عمومی</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="ads-field-3"  class="ads-field-banner" name="is_general" value="1" {{ $coupon->is_general == 1 ? 'checked' : ''  }} type="radio"/>
                        <label for="ads-field-3">اختصاصی</label>
                    </div>
                </div>


                <div class="d-flex multi-text">
                <x-input type="text" name="title" placeholder="عنوان تخفیف"  value="{{ $coupon->title }}"/>
                <x-input type="text" name="code" placeholder="کد تخفیف"  value="{{ $coupon->code }}"/>
                <x-input type="number" name="percent" placeholder="درصد تخفیف"  value="{{ $coupon->percent }}"/>
                <x-input type="number" name="limit" placeholder="مقدار تخفیف"  value="{{ $coupon->limit }}"/>
                <x-input type="number" name="quantity" placeholder="تعداد تخفیف"  value="{{ $coupon->quantity }}"/>
                </div>

                <div class="d-flex multi-text">
                    <x-select name="user_id[]">
                        @foreach ($users as $user)
                            <option value="{{$user->id}}" {{ $coupon->users()->pluck('id')->contains($user->id) ? 'selected' : '' }}>
                                {{$user->name}}</option>
                        @endforeach
                    </x-select>

                    <x-select name="category_id[]">
                        @foreach( $categories as $category)
                            <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </x-select>

                    <select name="product_id[]">
                        @foreach ($products as $product)
                            <option value="{{$product->id}}"
                                {{ $coupon->products()->pluck('id')->contains($product->id) ? 'selected' : '' }}>
                                {{$product->title}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex multi-text">
                    <x-input type="text" name="start_at" placeholder="تاریخ شروع" value="{{$coupon->start_at}}" class="text" id="start_at" required />
                    <x-input type="text" name="expired_at" placeholder="تاریخ انقضا" value="{{$coupon->expired_at}}" class="text" id="expired_at" required />
                </div>

                <button class="btn btn-webamooz_net">اضافه کردن</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('/panel/js/persianDatepicker.min.js')}}"></script>
    <script>
        $("#start_at").persianDatepicker();
        $("#expired_at").persianDatepicker();
    </script>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/panel/css/persianDatepicker-default.css')}}">
@endsection

