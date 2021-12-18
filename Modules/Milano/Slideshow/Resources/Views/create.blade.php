@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('slideshows.index') }}" title="اسلاید">اسلاید</a></li>
    <li><a href="#" title="اسلاید جدید">اسلاید جدید</a></li>
@endsection
@section('content')
<div class="main-content padding-0">
    <p class="box__title">ایجاد اسلاید جدید</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('slideshows.store') }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf

                <x-input name="title" type="text" placeholder="عنوان اسلاید" required/>
                <x-input name="link" type="text" placeholder="لینک اسلاید" required/>

                <input type="file" name="image" required oninvalid="this.setCustomValidity
                ('فیلد تصاویر اسلاید الزامی است')" multiple placeholder="تصویر اسلاید">
                <br>
                <button class="btn btn-webamooz_net">ذخیره</button>
            </form>
        </div>
    </div>
</div>
@endsection
