@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="#" title="همکاری با ما">همکاری با ما</a></li>
@endsection
@section('content')
    @can(Milano\Rolepermissions\Models\Permission::PERMISSION_MANAGE_SELLERS)
        <div class="row no-gutters">
            <div class="col-12 bg-white">
                <p class="box__title">همکاری با ما</p>
                <form action="{{route('sellers.store')}}" class="padding-30" method="post" enctype="multipart/form-data">
                    @csrf
                    <x-input name="titre" type="text" placeholder=" تیتر "  value="{{ $seller->titre }}" required/>
                    <x-input name="title1" type="text" placeholder=" سهم سایت "  value="{{ $sellers->title1 }}" required/>
                    <x-input name="percent" type="text" placeholder="سهم سایت از فروش محصول"  value="{{ $sellers->percent}}" required/>
                    <x-input name="title2" type="text" placeholder=" قیمت گذاری"  value="{{ $sellers->title2 }}" required/>
                    <x-input name="price" type="text" placeholder="قوانین قیمت گذاری محصول"  value="{{ $sellers->price }}" required/>
                    <x-input name="title3" type="text" placeholder=" تسویه حساب"  value="{{ $sellers->title3 }}" required/>
                    <x-input name="payment" type="text" placeholder="نحوه تسویه حساب با فروشنده"  value="{{ $sellers->payment }}" required/>
                    <x-input name="telegram" type="text" placeholder="کسب اطلاعات بیشتر (تلگرام)"  value="{{ $sellers->telegram }}" required/>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="last-name-column">درصد</label>
                            <input type="file" name="image1" id="courses" class="form-control" placeholder="درصد">
                        </div>
                        <span><img src="{{asset('/storage/' . $sellers->image1)}}" alt="" class="rounded-circle" width="80"></span>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="last-name-column">قیمت</label>
                            <input type="file" name="image2" id="courses" class="form-control" placeholder="قیمت">
                        </div>
                        <span><img src="{{asset('/storage/' . $sellers->image2)}}" alt="" class="rounded-circle"  width="80"></span>
                    </div>

                   <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="last-name-column">تسویه حساب</label>
                            <input type="file" name="image3" id="courses" class="form-control" placeholder="تسویه حساب">
                        </div>
                        <span><img src="{{asset('/storage/' . $sellers->image3)}}" alt="" class="rounded-circle"  width="80"></span>
                    </div>
                    <x-input name="title" type="text" placeholder="عنوان" value="{{ $sellers->title }}" required/>
                    <x-input name="head1" type="text" placeholder="انتخاب موضوع همکاری" value="{{ $sellers->head1 }}" required/>
                    <x-input name="head2" type="text" placeholder="متن قرارداد" value="{{ $sellers->head2 }}" required/>
                    <x-input name="head3" type="text" placeholder="استاندارهای محصول قابل ارائه " value="{{ $sellers->head3 }}" required/>

                    <textarea id="mytextarea" name="product" placeholder=" محصولات جهت همکاری ">{!! $sellers->product !!}</textarea><br>
                    <textarea id="mytextarea" name="standard" placeholder="استاندارهای محصول قابل ارائه ">{!! $sellers->standard !!}</textarea><br>
                    <textarea id="mytextarea" name="rules" placeholder="متن قرارداد">{!! $sellers->rules !!}</textarea><br>

                    <button type="submit" class="btn btn-webamooz_net">ثبت تغییرات</button>
                </form>
            </div>
        </div>
    @endcan
@endsection

