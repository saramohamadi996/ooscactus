@extends('Front::layout.master')
@section('content')
    <main id="index">
        <article class="container article">
            <div class="top-info"></div>
            <div class="box-filter">
                <div class="b-head">
                    <h2>دوره های یافت شده</h2>
                </div>
                <div class="posts">
                    @forelse($searchProducts as $product)
                        <div class="col">
                            <a href="{{$product->path()}}">
                                <div class="product-status">
                                    @lang($product->status)
                                </div>
                                <div class="discountBadge"><p>20%</p>تخفیف</div>
                                <div class="card-img"><img src="{{asset('/storage/' . $product->image)}}" alt="{{ $product->title }}"></div>
                                <div class="card-title"><h2>{{ $product->title }}</h2></div>
                                <div class="card-body">
                                    <img src="{{$product->sellerImage}}" alt="{{ $product->seller->name }}">
                                    <span>{{ $product->seller->name }}</span>
                                </div>
                                <div class="card-details">
                                    <h4>تومان</h4>
                                    <div class="price">
                                        <div class="discountPrice">{{ number_format($product->price) }}</div>
                                        <div class="endPrice">{{number_format($product->price) }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @empty
                        <h3>محصولی یافت نشد</h3>
                    @endforelse

                </div>
            </div>
            <article class="container blog">
                <div class="b-head">
                    <h2>مقالات یافت شده</h2>
                </div>
                <div class="articles">
                    @forelse($searchArticles as $article)
                        <div class="col">
                            <a href="{{$article->path()}}">
                                <div class="card-img"><img src="{{'/storage/' . $article->image}}" alt="reactjs"></div>
                                <div class="card-title"><h2>
                                    {{$article->title}}
                                    </h2>
                                </div>
                                <div class="card-body">

                                </div>
                                <div class="card-details">
                                    <span class="b-view">{{$article->viewCount}}</span>
                                    <span class="b-category">دسته بندی :
                                        @foreach($article->categories as $cat)
                                            {{$cat->title}}
                                        @endforeach
                                    </span>
                                </div>
                            </a>
                        </div>
                        @empty

                        <h3>مقاله ای یافت نشد</h3>
                    @endforelse
                </div>
            </article>
        </article>

    <main id="single">

@endsection

