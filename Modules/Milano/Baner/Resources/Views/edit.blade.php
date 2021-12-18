@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('baners.index') }}" title=" شبکه های اجماعی">شبکه های اجماعی</a></li>
    <li><a href="#" title="ویرایش شبکه">ویرایش شبکه</a></li>
@endsection
@section('content')
<div class="main-content padding-0">
    <p class="box__title">ویرایش شبکه</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('baners.update', $baner->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="d-flex multi-text">
                <x-input name="title" type="text" placeholder="عنوان شبکه" value="{{ $baner->title }}" required/>
                <x-input name="link" type="text" placeholder="لینک شبکه" value="{{ $baner->link }}" required/>
                </div>

                <div clsss="form-group"><img src="{{'/storage/' . $baner->image}}"  width="80"></div>
                <input type="file" name="image" oninvalid="this.setCustomValidity
                ('فیلد تصویر شبکه الزامی است')" multiple placeholder="تصویر شبکه">

                <button class="btn btn-webamooz_net">ذخیره</button>
            </form>
        </div>
    </div>
</div>
@endsection
