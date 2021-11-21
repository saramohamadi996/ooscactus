@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('baners.index') }}" title=" شبکه های اجتماعی">شبکه های اجتماعی</a></li>
    <li><a href="#" title="شبکه اجتماعی جدید">شبکه اجتماعی جدید</a></li>
@endsection
@section('content')
<div class="main-content padding-0">
    <p class="box__title">ایجاد شبکه اجتماعی جدید</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('baners.store') }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf

                <div class="d-flex multi-text">
                <x-input name="title" type="text" placeholder="عنوان شبکه اجتماعی" required/>
                <x-input name="link" type="text" placeholder="لینک شبکه اجتماعی" required/>
                </div>
                <input type="file" name="image" required  oninvalid="this.setCustomValidity('فیلد تصویر شبکه اجتماعی الزامی است')" multiple placeholder="تصویر شبکه اجتماعی">
                <br>
                <br>
                <button class="btn btn-webamooz_net">ذخیره</button>
            </form>
        </div>
    </div>
</div>
@endsection
