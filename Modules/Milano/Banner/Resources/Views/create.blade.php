@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('banners.index') }}" title=" بنرها">بنرها</a></li>
    <li><a href="#" title="بنر جدید">بنر جدید</a></li>
@endsection
@section('content')
<div class="main-content padding-0">
    <p class="box__title">ایجاد بنر جدید</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('banners.store') }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf

                <div class="d-flex multi-text">
                <x-input name="title" type="text" placeholder="عنوان بنر" required/>
                <x-input name="link" type="text" placeholder="لینک بنر" required/>
                </div>
                <input type="file" name="image" required
                       oninvalid="this.setCustomValidity('فیلد تصاویر بنر الزامی است')" multiple placeholder="تصویر بنر">
<br>
<br>
                <button class="btn btn-webamooz_net">ذخیره</button>
            </form>
        </div>
    </div>
</div>
@endsection
