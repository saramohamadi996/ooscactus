
<div class="box-filter">
    <div class="b-head">
        <h2>جدید ترین محصولات</h2>
        <a href="{{route('allProducts.product')}}">مشاهده همه</a>
    </div>
    <div class="posts">
        @foreach($latestProducts as $productItem)
            @include('Front::layout.singleProductBox')
        @endforeach
    </div>
</div>
