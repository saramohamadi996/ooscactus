@extends('Front::layout.master')
@section('content')

    <main id="single">
        <div class="content">
            <div class="container">
                <article class="article">
                    @include('Front::layout.header-ads')
                    <br>
                    <div class="h-t">
                        <h1 class="title">{{$product->title}}</h1>
                        <div class="breadcrumb">

                            <ul>
                                <li><a href="/" title="خانه">خانه</a></li>
                                @if($product->category->parentCategory)
                                    <li><a href="{{$product->category->parentCategory->path()}}"
                                           title="{{$product->category->parentCategory->title}}">
                                            {{$product->category->parentCategory->title}}</a>
                                    </li>
                                @endif
                                <li><a href="{{$product->category->path()}}"
                                       title="{{$product->category->title}}">{{$product->category->title}}</a></li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
            <div class="main-row container">
                <div class="sidebar-right">
                    <div class="sidebar-sticky" style="top: 155px;">
                        <div class="product-info-box">
                            @if($product->coupon != null)
                                <div class="discountBadge">
                                    <p>{{ $product->coupon }}%</p>
                                    تخفیف
                                </div>
                            @endif
                            @auth
                                @if(auth()->id() == $product->seller_id)
                                    <p class="mycourse">شما فروشنده این محصول هستید</p>
                                @elseif($product->stock <= 0 )
                                    <p>محصول موجود نمی باشد</p>
                                @else
                                    <div class="sell_course">
                                        <strong>قیمت :</strong>

                                        @if($product->getDiscount())
                                            <del class="discount-Price">{{ $product->getFormattedPrice() }}</del>
                                            {{--                                        @endif--}}
                                            <p class="price">

                                                {{-- <span class="woocommerce-Price-amount amount">{{ number_format($product->price) }}--}}
                                                <span class="woocommerce-Price-amount amount">{{ $product->getFormattedFinalPrice() }}
                                                <span class="woocommerce-Price-currencySymbol">تومان</span>
                                            </span>
                                            </p>
                                            <dev
                                                class="discount-Price">{{number_format($product->price * ((100-$product->coupon)/100))}}</dev>
                                        @else
                                            <div class="wooco" style="padding-right: 50px">
                                                {{ number_format($product->price) }}
                                                <span class="woocommerce-Price-currencySymbol">تومان</span>
                                            </div>
                                        @endif
                                    </div>
                                    @error('addtocart')
                                    <div>{{$message}}</div>
                                    @enderror
                                    @if (session('success'))
                                        <div>{{session('success')}}</div>
                                    @endif

                                    <form method="post" action="{{route('cart.add')}}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <button type="submit" class="btn buy">خرید محصول</button>
                                    </form>
                                @endif
                            @else
                                <div class="sell_course">
                                    <strong>قیمت :</strong>

                                    @if($product->getDiscount())
                                        <del class="discount-Price">{{ $product->getFormattedPrice() }}</del>
                                    @endif

                                    <p class="price">
                                        <span class="woocommerce-Price-amount amount">{{ $product->getFormattedPrice() }}
                                            <span class="woocommerce-Price-currencySymbol">تومان</span>
                                        </span>
                                    </p>
                                </div>

                                <p>جهت خرید محصول ابتدا در سایت لاگین کنید</p>
                                <a href="{{ route('login')}}" class="btn text-white w-100">ورود به سایت</a>
                            @endauth
                            <div class="average-rating-sidebar">
                                <div class="rating-stars">
                                    <div class="slider-rating">
                                        <span class="slider-rating-span slider-rating-span-100" data-value="100%"
                                              data-title="خیلی خوب"></span>
                                        <span class="slider-rating-span slider-rating-span-80" data-value="80%"
                                              data-title="خوب"></span>
                                        <span class="slider-rating-span slider-rating-span-60" data-value="60%"
                                              data-title="معمولی"></span>
                                        <span class="slider-rating-span slider-rating-span-40" data-value="40%"
                                              data-title="بد"></span>
                                        <span class="slider-rating-span slider-rating-span-20" data-value="20%"
                                              data-title="خیلی بد"></span>
                                        <div class="star-fill"></div>
                                    </div>
                                </div>
                                <div class="average-rating-number">
                                    <span class="title-rate title-rate1">امتیاز</span>
                                    <div class="schema-stars">
                                        <span class="value-rate text-message"> 4 </span>
                                        <span class="title-rate">از</span>
                                        <span class="value-rate"> 555 </span>
                                        <span class="title-rate">رأی</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-info-box">
                            <div class="product-meta-info-list">
                                <div class="meta-info-unit four">
                                    <span class="title">فروشنده محصول : </span><span
                                        class="vlaue">{{$product->seller->name}}</span>
                                </div>
                                <div class="meta-info-unit seven">
                                    <span class="title">کد محصول :</span><span class="vlaue">{{$product->stock}}</span>
                                </div>
                                <div class="meta-info-unit two">
                                    <span class="title">وضعیت محصول : </span><span
                                        class="vlaue">@lang($product->status)</span>
                                </div>
                                <div class="meta-info-unit five">
                                    <span class="title">تعداد محصول :</span><span
                                        class="vlaue">{{$product->stock}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="course-teacher-details">
                            <div class="top-part">
                                <a href="{{ route('singleTutor', auth()->user(), $product->seller->username) }}">
                                    <img alt="{{$product->seller->name}}" class="img-fluid lazyloaded"
                                         src="{{$product->sellerImage}}" loading="lazy">
                                    <noscript><img class="img-fluid" src="{{$product->seller->sellerImage}}"
                                                   alt="{{$product->seller->name}}"></noscript>
                                </a>

                                <div class="name">
                                    <a href="{{ route('singleTutor', auth()->user(), $product->seller->username) }}">
                                        <h6>{{$product->seller->name}}</h6>
                                    </a>
                                    <span class="job-title">{{$product->seller->headline}}</span>
                                </div>
                            </div>
                            <div class="job-content"><p>{{$product->seller->bio}}</p></div>
                        </div>
                        <div class="short-link">
                            <div class="">
                                <span>لینک کوتاه</span><input class="short--link" value="{{$product->shortUrl()}}">
                                <a href="{{$product->shortUrl()}}" class="short-link-a"
                                   data-link="{{$product->shortUrl()}}"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-center">
                    <div class="preview" style="margin-left: -35%; padding-right: 10%">
                        <div class="sp-wrap">
                            @foreach($product->images as $image)
                                <div class="sp-current-big">
                                    <a href="{{'/storage/' . $image->src}}">
                                        <img src="{{'/storage/' . $image->src}}" alt="{{$product->title}}"></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="course-description">
                        <div class="course-description-title">توضیحات محصول</div>
                        {!! $product->body !!}
                        <div class="tags">
                            <ul>
                                <li><a href="">کاکتوس بذری</a></li>
                                <li><a href="">کاکتوس تیغی</a></li>
                                <li><a href=""> ساکولنت</a></li>
                                <li><a href="">کاکتوس تزیینی</a></li>
                                <li><a href="">کاکتوس </a></li>
                                <li><a href="">گل های آپارتمانی</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="sidebar-right">
                    <div class="sidebar-sticky" style="top: 155px;">
                        <div class="product-info-box">
                            <div class="course-description">
                                <div>@include('Front::layout.sidebar-banners')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include("Front::comments.index", ["commentable" => $product])
        </div>
    </main>
@endsection
@section('js')
    <script>
        var $easyzoom = $('.easyzoom').easyZoom();
    </script>
@endsection

