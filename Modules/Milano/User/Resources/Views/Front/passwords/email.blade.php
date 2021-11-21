@extends('User::front.maste')

@section('content')
    <form action="{{route('password.email')}}" class="form" method="post">
        @csrf
        <a class="account-logo" href="/">
            <img src="/storage/{{\Milano\Setting\Models\Setting::first()->logo ?? ''}}"
                 alt="{{\Milano\Setting\Models\Setting::first()->title ?? ''}}">
        </a>
        <div class="form-content form-account">
            <input type="email" name="email" id="email"  class="txt-l txt" placeholder="ایمیل">
            <br>
            <button class="btn btn-recoverpass">بازیابی</button>
        </div>
        <div class="form-footer">
            <a href={{route('login')}}>صفحه ورود</a>
        </div>
    </form>
@endsection
