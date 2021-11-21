@extends('User::front.maste')
@section('content')
    <div class="form">
        <a class="account-logo" href="/">
            <img src="/storage/{{\Milano\Setting\Models\Setting::first()->logo ?? ''}}"
                 alt="{{\Milano\Setting\Models\Setting::first()->title ?? ''}}">
        </a>
        <div class="form-content form-account">

            <div class="card-header">تایید حساب کاربری</div>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    یک ایمیل جدید برای شما ارسال شد.
                </div>
            @endif
            ایمیل فعالسازی حساب برای شما ارسال شده است.
            لطفا قبل از ادامه ایمیل خود را چک کنید.اگر ایمیل دریافت نکرده بودید روی دکمه ارسال مجدد کلیک کنید
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">ارسال مجدد</button>
                <a href="/"> بازگشت به صفحه اصلی</a>
            </form>
        </div>
@endsection
