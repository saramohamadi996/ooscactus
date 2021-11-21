@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('coupons.index') }}" title="تخفیف ها">تخفیف ها</a></li>
    <li><a href="{{route('coupons.store')}}" title="ایجاد تخفیف">ایجاد تخفیف</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد تخفیف</p>
            <form action="{{route('coupons.store')}}" method="post" class="padding-30">
            @csrf
                <p class="box__title">وضعیت تخفیف</p>
                <div class="w-50">
                    <div class="notificationGroup">
                        <input id="ads-field-1" class="ads-field-pn" name="is_general" value="0" type="radio" checked/>
                        <label for="ads-field-1">عمومی</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="ads-field-3"  class="ads-field-banner" name="is_general" value="1" type="radio"/>
                        <label for="ads-field-3">اختصاصی</label>
                    </div>
                </div>

            <div class="d-flex multi-text">
            <x-input type="text" name="title" placeholder="عنوان تخفیف" required/>
            <x-input type="text" name="code" placeholder="کد تخفیف"/>
            <x-input type="number" name="percent" placeholder="درصد تخفیف"/>
            <x-input type="number" name="limit" placeholder="مقدار تخفیف"/>
            <x-input type="number" name="quantity" placeholder="تعداد تخفیف"/>
            </div>

                 <div class="d-flex multi-text">

            <x-select name="user_id" id="user_id">
                <option value="">تخفیف برای کاربر</option>
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </x-select>

                     <x-select name="category_id[]" id="category_id[]">
                         <option value="" >دسته بندی</option>
                         @foreach( $categories as $category)
                             <option value="{{$category->id}}"
                                 {{$category->id == old('category_id') ?'selected' : ''}}>{{$category->title}}</option>
                         @endforeach
                     </x-select>

            <x-select name="product_id" id="">
            <option value="">تخفیف برای محصول</option>
            @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->title}}</option>
            @endforeach
            </x-select>
                </div>

                <div class="d-flex multi-text">
                    <x-input type="text" name="start_at" placeholder="تاریخ شروع"  class="text" id="start_at" required />
                    <x-input type="text" name="expired_at" placeholder="تاریخ انقضا"  class="text" id="expired_at" required />
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
