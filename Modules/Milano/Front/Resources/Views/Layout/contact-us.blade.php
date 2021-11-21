@extends('Front::layout.master')
@section('content')
<main id="index">
    <br>
    <br>
    <article class="container contact-us">
        <h2 class="h2">پل‌های ارتباطی</h2>
        <p>تلگرام :{{\Milano\Setting\Models\Setting::first()->telegram ?? ''}}</p>
        <p>واتساپ : {{\Milano\Setting\Models\Setting::first()->whatsapp ?? ''}}</p>
        <p>اینستاگرام : {{\Milano\Setting\Models\Setting::first()->instagram ?? ''}}</p>
        <p>ایمیل : {{\Milano\Setting\Models\Setting::first()->email ?? ''}}</p>
        <p>شماره موبایل (فقط تلگرام یا واتساپ): {{\Milano\Setting\Models\Setting::first()->mobile ?? ''}}</p>
        <p>آدرس {{\Milano\Setting\Models\Setting::first()->address ?? ''}}</p>
    </article>
</main>
@endsection
