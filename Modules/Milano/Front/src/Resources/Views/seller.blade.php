@extends('Front::layout.master')
@section('content')
<main id="index">
    <div class="entry-content">
        <div class="container">
            @foreach($sellers as $seller)
                <br>
                <br>
                <p>{{$seller->titre}}</p>

                <div class="teaching-conditions">
                <div class="col--3">
                    <div class="col-3-head">
                        <img src="{{'/storage/' . $seller->image1}}" alt="{{$seller->title1}}">
                    </div>
                    <div class="col-3-contnet">
                        <strong>{{ $seller->title1}}</strong>
                        <p> {{$seller->percent}}</p>
                    </div>
                </div>
                <div class="col--3">
                    <div class="col-3-head">
                        <img src="{{'/storage/' . $seller->image2}}" alt="{{$seller->title2}}">
                    </div>
                    <div class="col-3-contnet">
                        <strong>{{ $seller->title2}}</strong>
                        <p>{{ $seller->price}}</p>
                    </div>
                </div>
                <div class="col--3">
                    <div class="col-3-head">
                        <img src="{{'/storage/' . $seller->image3}}" alt="{{$seller->title3}}">
                    </div>
                    <div class="col-3-contnet">
                        <strong>{{$seller->title3}}</strong>
                        <p>{{$seller->payment}}</p>
                    </div>
                </div>
            </div>

            <p class="id-tel">{{$seller->telegram}}</p>
            <div class="how-to-become-a-teacher">
                <div class="how-to-become-a--teacher">
                    <h2>{{$seller->title}}</h2>
                    <div class="bt-accrdion">
                        <ul class="bt-accrdion-ul">
                            <li class="bt-accrdion-li">{{$seller->head1}}
                                <div class="bt-accrdion-div">
                                    <ul><li>{{$seller->product}}</li></ul>
                                </div>
                            </li>
                            <li class="bt-accrdion-li">{{$seller->head2}}
                                <div class="bt-accrdion-div">
                                    <ul><li>{{$seller->standard}}</li></ul>
                                </div>
                            </li>
                            <li class="bt-accrdion-li">{{$seller->head3}}
                                <div class="bt-accrdion-div">
                                    <ul><li>{{$seller->rules}}</li></ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
                <div class="how-to-become-a--teacher">
                    <h2>فرم ثبت نام فروشنده</h2><br>
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success">{{Session::get('flash_message')}}</div>
                        @endif
                    <form action="{{route('seller.singleStore')}}" class="how-to-become-a--teacher-form"
                          method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="text" name="name" id="name" class="txt  @error('name') is-invalid @enderror"
                         placeholder="نام و نام خانوادگی" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <input type="text" name="nationalCode" id="nationalCode" class="txt txt-l @error('nationalCode')
                        is-invalid @enderror" placeholder="کد ملی" value="{{ old('nationalCode') }}" required autocomplete="nationalCode">
                        @error('nationalCode')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <input type="email" name="email" id="email" class="txt txt-l @error('email') is-invalid @enderror"
                        placeholder="ایمیل" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <input type="text" name="mobile" id="mobile" class="txt txt-l @error('mobile') is-invalid @enderror"
                        placeholder="موبایل (با عدد 9 آغاز شود)" value="{{ old('mobile') }}" required autocomplete="mobile">
                        @error('mobile')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <input type="text" name="telegram" class="txt txt-l @error('mobile')
                            is-invalid @enderror" placeholder="ایدی یا شماره تلگرام">

                        <input type="text" name="shop" id="shop" class="txt  @error('shop') is-invalid @enderror"
                               placeholder="نام فروشگاه شما در سایت اوس کاکتوس" value="{{ old('shop') }}" required autocomplete="shop" autofocus>
                        @error('shop')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <input type="text" name="products" id="products" class="txt  @error('products') is-invalid @enderror"
                               placeholder="قصد فروش چه محصولاتی را دارید؟ " value="{{ old('products') }}" required autocomplete="products" autofocus>
                        @error('products')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <input type="text" name="Address" id="Address" class="txt  @error('Address') is-invalid @enderror"
                               placeholder="آدرس خود را به صورت کامل وارد نمایید " value="{{ old('Address') }}" required autocomplete="Address" autofocus>
                        @error('Address')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <button type="submit" class="btn btn-webamooz_net">ارسال</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
