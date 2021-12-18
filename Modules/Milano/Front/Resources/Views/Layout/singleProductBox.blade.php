
<div class="col">
    <a href="{{$productItem->path()}}">
        <div class="product-status">
{{--            @lang($productItem->status)--}}
        </div>

        @if($productItem->getDiscountPercent())
            <div class="discountBadge">
                <p>{{ $productItem->getDiscountPercent() }}%</p>
                تخفیف
            </div>
        @endif

        <div class="card-img"><img src="{{asset('/storage/' . $productItem->image)}}"
                                   alt="{{ $productItem->title }}"></div>
        <div class="card-title"><h2>{{ $productItem->title }}</h2></div>
        <div class="card-body">
            <img src="{{$productItem->sellerImage}}" alt="{{ $productItem->seller->name }}">
            <span>{{ $productItem->seller->name }}</span>
        </div>

        <div class="card-details">
{{--            <div class="time">{{ $productItem->formattedDuration() }}تومان</div>--}}
            <div class="price">
                @if($productItem->getDiscountPercent())
                    <div class="discountPrice">{{ $productItem->getFormattedPrice() }}</div>
{{--                <div class="discountPrice">{{ number_format($productItem->price) }}</div>--}}
                <div class="endPrice">{{number_format($productItem->price * ((100-$productItem->coupon)/100)) }}</div>
                @endif
{{--                @else--}}
                    <div>{{ number_format($productItem->price) }}</div>
{{--                @endif--}}
            </div>
        </div>
    </a>
</div>
