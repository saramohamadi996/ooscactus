@extends('User::front.maste')

@section('content')
    <form action="{{route('password.update')}}" class="form" method="post">
        <input type="hidden" name="token" value="{{ $token }}">
    @csrf
        <a class="account-logo" href="index.html">
            <img src="/storage/{{\Milano\Setting\Models\Setting::first()->logo ?? ''}}"
                 alt="{{\Milano\Setting\Models\Setting::first()->title ?? ''}}">
        </a>

        <div class="form-content form-account">
            <x-input id="email" type="email" class="txt txt-l" placeholder="ایمیل" name="email"
                     value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus/>

            <x-input id="password" type="password" class="txt txt-l" placeholder="رمز عبور"
                   name="password" required autocomplete="new-password"/>

            <input id="password-confirm" type="password" class="txt txt-l" placeholder="تکرار رمز عبور"
                   name="password_confirmation" required autocomplete="new-password">
            <span class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ،
                حروف کوچک، اعداد و کاراکترهای غیر الفبا مانند !@#$%^&*() باشد.</span>
            <br>
            <button class="btn continue-btn">ثبت نام و ادامه</button>

        </div>
        <div class="form-footer">
            <a href="{{route('login')}}">صفحه ورود</a>
        </div>
    </form>
@endsection

