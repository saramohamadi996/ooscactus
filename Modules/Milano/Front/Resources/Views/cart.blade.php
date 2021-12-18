@extends('Front::layout.master')
@section('content')
    <main id="single">
        <div class="container">
            <article class="article">
                <br>
                <br>
                <div class="h-t">
                    <h1 class="title"></h1>
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="/" title="خانه">خانه</a></li>
                            <li><a href="{{route('cart.add')}}" title="فاکتور خرید">فاکتور خرید</a></li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
        <div class="main-row container">
            <div class="content article" style="width: 70%;  padding-left: 2%; margin-bottom: 5%;">
                <div class="preview">
                    <div class="course-description">
                        <div class="table-cart mCustomScrollbar _mCS_1 mCS_no_scrollbar">
                            <div class="flat-row-title style1">

                                <h3>فاکتور خرید</h3></div>
                            <div class="modal">
                                <div class="modal-content">
                                    <div>
                                        <table class="table text-center">
                                            <thead>
                                            <tr>
                                                <th>تصویر</th>
                                                <th>کد محصول</th>
                                                <th>محصول</th>
                                                <th>قیمت</th>
                                                <th>جمع</th>
                                                <th>درصد تخفیف</th>
                                                <th> مبلغ تخفیف</th>
                                                <th> قابل پرداخت</th>
                                                <th>تعداد</th>
                                                <th>حذف</th>
                                            </tr>
                                            </thead>

                                            <div id="Modal-buy" class="modal">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <p>کد تخفیف را وارد کنید</p>
                                                        <div class="close">&times;</div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="">
                                                            @csrf
                                                            <div>
                                                                <input type="text" name="code" id="code" class="txt" placeholder="کد تخفیف را وارد کنید">
                                                                <p id="response"></p>
                                                            </div>
                                                            <button type="button" class="btn i-t " onclick="checkDiscountCode()">اعمال
                                                                <img src="/img/loading.gif" alt="" id="loading" class="loading d-none">
                                                            </button>

                                                            <table class="table text-center table-bordered table-striped">
                                                                <tbody>
                                                                @foreach($products as $product)
                                                                    <tr>
                                                                        <td width="100"><img src="/storage/{{$product->image}}" width="100">
                                                                        </td>
                                                                        <td>{{$product->code_product}}</td>
                                                                        <td>{{$product->title}}</td>
                                                                        <td>{{number_format($product->pivot->price * ((100-$product->coupon)/100))}}</td>
                                                                        <td>{{number_format($product->pivot->total_price)}}</td>

                                                                        <td><span id="discountPercent"
                                                                                  data-value="{{ $product->getDiscountPercent()  }}">{{ $product->getDiscountPercent() }}</span>%
                                                                        </td>
                                                                        <td class="text-red"><span
                                                                                id="discountAmount"
                                                                                data-value="{{ $product->getDiscountAmount()  }}"> {{ $product->getDiscountAmount() }}</span>
                                                                            تومان
                                                                        </td>

                                                                        <td class="text-blue"><span
                                                                                id="payableAmount"
                                                                                data-value="{{ $product->getFinalPrice()  }}">{{ $product->getFormattedFinalPrice() }}</span>
                                                                            تومان
                                                                        </td>
                                                                        <form method="post" action="{{route('cart.update', $product->id)}}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <td>
                                                                                <input class="pro-quantity" type="hidden" name="product"
                                                                                       value="{{$product->id}}" id="">
                                                                                <input class="pro-qty" type="number" name="count"
                                                                                       value="{{$product->pivot->count}}">
                                                                                <a href="#" class="inc qty-btn">+</a><a href="#" class="dec qty-btn">-</a>
                                                                                <button type="submit" class="bt"
                                                                                        style="background: #46b2d0; color: #ffffff; border-radius: 2px; width: 60px">
                                                                                    بروزرسانی
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                        <td>
                                                                            <form method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <input type="hidden" name="product" value="{{$product->id}}"
                                                                                       id="">
                                                                                <button type="submit" class="item-delete mlg-15"
                                                                                        style="width: 0px"></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                            <button type="submit" class="btn btn i-t ">پرداخت آنلاین</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar-left" style="width: 30%; padding-top:1%;">
                <div class="sidebar-sticky">
                    <div class="product-info-box">
                        <div class="course-description">
                            <h3>جمع فاکتور خرید</h3>
                            <br>
                            <div>
                                <form method="post" action="{{ route("orders.checkout") }}">
                                    @csrf
                                    <input type="hidden" name="cart_id" value="{{$cart->id}}">
                                    <table class="table text-center table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>جمع کل</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{number_format($cart->total_price)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div style="padding-right:14%;">
                                        <button type="submit" class="btn i-t">ادامه فرآیند خرید</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection



@section('js')
    <script src="/js/modal.js"></script>
    <script>
        function checkDiscountCode() {
            $("#loading").removeClass("d-none")
            const code = $("#code").val();
            const url = "{{ route("discounts.check", ["code", $product->id]) }}";
            $("#loading").addClass("d-none")
            $("#response").text("")
            $.get(url.replace("code", code))
                .done(function (data) {
                    $("#discountPercent").text( parseInt($("#discountPercent").attr("data-value")) +  data.discountPercent)
                    $("#discountAmount").text(parseInt($("#discountAmount").attr("data-value")) + data.discountAmount)
                    $("#payableAmount").text(parseInt($("#payableAmount").attr("data-value")) - data.discountAmount)
                    $("#response").text("کد تخفیف با موفقیت اعمال شد.").removeClass("text-error").addClass("text-success")
                })
                .fail(function (data) {
                    $("#response").text("کد وارده شده برای این درس معتبر نیست.").removeClass("text-success").addClass("text-error")
                })
                .always(function () {
                    $("#loading").addClass("d-none")
                })
        }
    </script>
@endsection
