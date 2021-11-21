@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('banners.index') }}" title=" بنرها">بنرها</a></li>
    <li><a href="#" title="ویرایش بنر">ویرایش بنر</a></li>
@endsection
@section('content')
<div class="main-content padding-0">
    <p class="box__title">ویرایش بنر</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('banners.update', $banner->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="d-flex multi-text">
                <x-input name="title" type="text" placeholder="عنوان بنر" value="{{ $banner->title }}" required/>
                <x-input name="link" type="text" placeholder="لینک بنر" value="{{ $banner->link }}" required/>
                </div>

                <div clsss="form-group"><img src="{{'/storage/' . $banner->image}}"  width="80"></div>
                <input type="file" name="image" oninvalid="this.setCustomValidity
                ('فیلد تصاویر بنر الزامی است')" multiple placeholder="تصویر بنر">

                <button class="btn btn-webamooz_net">ذخیره</button>
            </form>
        </div>
    </div>
</div>
@endsection
