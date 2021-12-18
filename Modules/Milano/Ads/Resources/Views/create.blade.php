@extends('Dashboard::master')
@section('breadcrumb')
        <li><a href="{{ route('adss.index') }}" title="تبلیغات ">تبلیغات </a></li>
        <li><a href="{{ route('adss.create') }}" class="is-active" >ایجاد تبلیغ جدید</a></li>
@endsection
@section('content')
<div class="main-content padding-0 create-ads">
    <p class="box__title">ایجاد تبلیغ جدید</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('adss.store') }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <p class="box__title">نوع تبلیغ را انتخاب کنید</p>
                <div class="w-50">
                    <div class="notificationGroup">
                        <input id="ads-field-1" class="ads-field-pn" name="ads" value="new-tab" type="radio" checked/>
                        <label for="ads-field-1">نیوتب</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="ads-field-2" class="ads-field-pn" name="ads" value="pop-ap" type="radio"/>
                        <label for="ads-field-2">پاپ آپ</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="ads-field-3"  class="ads-field-banner" name="ads" value="banner" type="radio"/>
                        <label for="ads-field-3">بنر</label>
                    </div>
                </div>
                <br>

                <div class="d-flex multi-text">
                <x-input type="text" name="title" placeholder="عنوان تبلیغ" required/>
                <x-input type="text" name="link" class="text" placeholder="لینک تبلیغ" required />
                </div>

                <div class="d-flex multi-text">
                <x-select name="page" required>
                    <option value=" ">صفحه مورد نظر برای تبلیغ</option>
                    @foreach(\Milano\Ads\Models\Ads::$pages as $page)
                    <option value="{{$page}}" @if($page == old('$page')) selected @endif>
                        @lang($page)</option>
                    @endforeach
                </x-select>

                <x-select name="opening" required>
                    <option value="">محدودیت باز شدن</option>
                    @foreach(\Milano\Ads\Models\Ads::$openings as $opening)
                    <option value="{{$opening}}" @if($opening == old('$opening')) selected @endif>
                        @lang($opening)</option>
                        @endforeach
                </x-select>
                </div>

                <div class="d-flex multi-text">
                <x-input type="text" name="start_at" placeholder="تاریخ شروع"  class="text" id="start_at" required />
                <x-input type="text" name="expired_at" placeholder="تاریخ انقضا"  class="text" id="expired_at" required />
                </div>

                <x-input type="file" name="image" required multiple placeholder="تصویر تبلیغ"/>
                <br>
                <button class="btn btn-webamooz_net">ایجاد تبلیغ</button>
            </form>
        </div>
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
