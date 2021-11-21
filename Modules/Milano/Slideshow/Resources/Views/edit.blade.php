@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('slideshows.index') }}" title="اسلاید">اسلاید</a></li>
    <li><a href="#" title="ویرایش اسلاید">ویرایش اسلاید</a></li>
@endsection
@section('content')
<div class="main-content padding-0">
    <p class="box__title">ویرایش اسلاید</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('slideshows.update', $slideshow->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <x-input name="title" type="text" placeholder="عنوان اسلاید" value="{{ $slideshow->title }}" required/>
                <x-input name="link" type="text" placeholder="لینک اسلاید" value="{{ $slideshow->link }}" required/>

                    <div clsss="form-group"><img src="{{'/storage/' . $slideshow->image}}"  width="80"></div>
                <input type="file" name="image" oninvalid="this.setCustomValidity('فیلد تصاویر اسلاید الزامی است')" multiple placeholder="تصویر اسلاید">
                <br>
                <button class="btn btn-webamooz_net">ذخیره</button>
            </form>
        </div>
    </div>
</div>
@endsection
