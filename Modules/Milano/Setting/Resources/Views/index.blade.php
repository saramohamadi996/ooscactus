@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('settings.index')}}" title="همکاری با ما">همکاری با  ما</a></li>
@endsection
@section('content')
<div class="main-content font-size-13">
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item " href="{{route('settings.create')}}">ویرایش اطلاعات</a>
        </div>
    </div>
    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>نماد</th>
                <th>لوگو</th>
                <th>عنوان</th>
                <th>ایمیل پشتیبانی</th>
                <th>شماره تماس</th>
                <th>تلگرام</th>
            </tr>
            </thead>
            <tbody>
            @foreach($settings as $setting)
                <tr role="row" class="">
                    <td width="80"><img src="{{asset('/storage/' . $setting->symbol)}}"  width="80"></td>
                    <td width="80"><img src="{{asset('/storage/' . $setting->logo)}}"  width="80"></td>
                    <td><a href="">{{$setting->title}}</a></td>
                    <td><a href="">{{ $setting->email}}</a></td>
                    <td><a href="">{{ $setting->mobile}}</a></td>
                    <td><a href="">{{ $setting->telegram}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
