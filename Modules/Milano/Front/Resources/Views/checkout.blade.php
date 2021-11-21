@extends('Front::layout.master')
@section('content')
<main id="single">
<div class="content">
<div class="main-row container">
<div class="content article" style="width: 50%; margin: 5%; margin-right: 310px;">
<div class="preview">
    <div class="course-description">
        <h3>اطلاعات گیرنده سفارش</h3>
    <form method="post" action="{{ route("orders.buy")}}">
        @csrf
        <input type="hidden" name="cart_id" value="{{$cart->id}}">
        <div class="form-content form-account">
            <x-input type="text" name="name" class="txt" placeholder="نام و نام خانوادگی*" autofocus required />
            <x-input type="text" name="mobile" class="txt txt-l" placeholder="موبایل گیرنده*" required />
            <x-input type="text" name="state" class="txt" placeholder="استان*" autofocus required />
             <x-input type="text" name="city" class="txt" placeholder="شهر*" autofocus required />
            <x-input type="text" name="street" class="txt" placeholder="خیابان" autofocus />
            <x-input type="text" name="alley" class="txt" placeholder="کوچه" autofocus />
            <x-input type="text" name="no" class="txt" placeholder="پلاک" autofocus />
            <div class="field-row">
                <label for="notes">یادداشت های سفارش</label>
                <textarea id="notes" placeholder="یادداشت هایی در مورد سفارش شما، به عنوان مثال یادداشت های ویژه برای تحویل."></textarea>
            </div>
        <button type="submit" class="btn i-t">پرداخت آنلاین</button>
        </div>
    </form>
    </div>
</div>
</div>
</div>
</div>
</main>
@endsection
