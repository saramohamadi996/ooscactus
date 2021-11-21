@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{route('settings.store')}}" title="تنظیمات">تنظیمات</a></li>
@endsection
@section('content')
    @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_SETTINGS)
        <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">تنظیمات</p>
            <form action="{{route('settings.store')}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <x-input name="title" placeholder="عنوان سایت" type="text" value="{{ $settings->title }}" required/>
                <x-input name="email" placeholder="ایمیل پشتیبانی" type="text" value="{{ $settings->email}}" required/>
                <x-input name="mobile" placeholder="شماره تماس" type="text" value="{{ $settings->mobile }}" required/>
                <x-input name="website" placeholder="وب سایت" type="text" value="{{ $settings->website }}" required/>
                <x-input name="telegram" placeholder="تلگرام" type="text" value="{{ $settings->telegram }}" required/>
                <x-input name="address" placeholder="آدرس" type="text" value="{{ $settings->address }}" required/>
                <x-input name="whatsapp" placeholder="واتس آپ" type="text" value="{{ $settings->whatsapp }}" required/>
               <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="last-name-column">لوگوی سایت</label>
                        <input type="file" name="logo" id="courses" class="form-control" placeholder="لوگوی سایت">
                    </div>
                    <span><img src="{{asset('/storage/' . $settings->logo)}}" alt="" class="rounded-circle" width="80"></span>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="last-name-column">نماد سایت</label>
                        <input type="file" name="symbol" id="courses" class="form-control" placeholder="نماد سایت">
                    </div>
                    <span><img src="{{asset('/storage/' . $settings->symbol)}}" alt="" class="rounded-circle"  width="80"></span>
                </div>

                <textarea id="mytextarea" name="body" placeholder="درباره ما">{!! $settings->body !!}</textarea><br>

                <button type="submit" class="btn btn-webamooz_net">ثبت تغییرات</button>
            </form>
        </div>
    </div>
    @endcan
@endsection
