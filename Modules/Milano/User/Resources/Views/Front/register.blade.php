@extends('User::Front.maste')
@section('content')
    <form action="{{route('register')}}" class="form" method="post">
        @csrf
        <a class="account-logo" href="/">
            <img src="/storage/{{\Milano\Setting\Models\Setting::first()->logo ?? ''}}"
                 alt="{{\Milano\Setting\Models\Setting::first()->title ?? ''}}">
        </a>
        <div class="form-content form-account">
                <x-input type="text" name="name" id="name" class="txt" placeholder="نام و نام خانوادگی"
                         value="{{ old('name') }}" required autocomplete="name" autofocus/>

            <x-input type="email" name="email" id="email" class="txt txt-l"
                   placeholder="ایمیل" value="{{ old('email') }}" required autocomplete="email"/>

            <x-input type="text" name="mobile" id="mobile" class="txt txt-l"
                   placeholder="موبایل" value="{{ old('mobile') }}" required autocomplete="mobile"/>

            <x-input type="password" name="password" id="password" class="txt txt-l"
                   placeholder="رمز عبور" required autocomplete="new-password"/>

            <x-input type="password" name="password_confirmation" id="password-confirm" class="txt txt-l"
                   placeholder="تکرار رمز عبور" required autocomplete="new-password"/>

            <span class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای غیر الفبا مانند !@#$%^&*() باشد.</span>
            <br>
            <button class="btn continue-btn">ثبت نام و ادامه</button>
        </div>
        <div class="form-footer">
            <a href="{{route('login')}}">صفحه ورود</a>
        </div>
    </form>
@endsection
