@extends('User::front.maste')

@section('content')
    <form action="{{route('login')}}" class="form" method="post">
        @csrf

        <a class="account-logo" href="/">
            <img src="/storage/{{\Milano\Setting\Models\Setting::first()->logo ?? ''}}"
                 alt="{{\Milano\Setting\Models\Setting::first()->title ?? ''}}">
        </a>
        <div class="form-content form-account">

            <x-input id="email" type="text" class="txt-l txt" placeholder="ایمیل یا موبایل یا نام کاربری"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>


            <x-input id="password" type="password" class="txt-l txt" placeholder="رمز عبور"
                   name="password" required autocomplete="current-password"/>

            <br>
            <button type="submit" class="btn btn--login">ورود</button>
        <label class="ui-checkbox">مرا بخاطر بسپار
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkmark"></span>
            </label>
            <div class="recover-password">
                <a href="{{route('password.request')}}">بازیابی رمز عبور</a>
            </div>

        </div>
        <div class="form-footer">
            <a href="{{route('register')}}">صفحه ثبت نام</a>
        </div>
    </form>
@endsection
