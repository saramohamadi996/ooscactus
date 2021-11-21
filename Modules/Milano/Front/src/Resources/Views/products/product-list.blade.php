@extends('Front::layout.master')
@section('content')
<main id="index">

    <article class="container article">
        <div class="box-filter">
            <br>
           <br><div class="b-head"><h2> همه محصولات</h2></div>

    <form action="{{route('allProducts.product')}}" method="get" id="formID">
        <select name="category" id="" class="box__title">
            <option value="">فیلتر براساس دسته بندی</option>
            @foreach($categories as $category)
                <option value="{{$category->slug}}">{{$category->slug}}</option>
            @endforeach
        </select>

        <select name="seller" id="" class="box__title">
            <option value=""> فیلتر بر اساس فروشنده</option>
            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}"
                 @if($seller->id == old('seller_id')) selected @endif>{{ $seller->name }}</option>
            @endforeach
        </select>

        <select name="status" id="" class="box__title">
            <option value="">فیلتر بر اساس موجودیت</option>
                <option value="available">موجود</option>
                <option value="unavailable">ناموجود</option>
        </select>

        <button type="submit" class="btn">فیلتر اطلاعات</button>
    </form>
           <div class="posts">
               @foreach($products as $productItem)
               <div class="col">
                   <a href="{{$productItem->path()}}">
                   <div class="product-status">@lang($productItem->status)</div>
                    <div class="discountBadge"><p>20%</p>تخفیف</div>
                   <div class="card-img"><img src="{{asset('/storage/' . $productItem->image)}}" alt="{{ $productItem->title }}"></div>
                   <div class="card-title"><h2>{{ $productItem->title }}</h2></div>
                    <div class="card-body">
                <img src="{{$productItem->sellerImage}}" alt="{{ $productItem->seller->name }}"><span>{{ $productItem->seller->name }}</span>
            </div>
                    <div class="card-details">
                <h4>تومان</h4>
                <div class="price">
                    <div class="discountPrice">{{ number_format($productItem->price) }}</div>
                    <div class="endPrice">{{number_format($productItem->price) }}</div>
                </div>
            </div>
                </a>
               </div>
              @endforeach
           </div>
        </div>
    </article>
<main id="single">
@endsection

