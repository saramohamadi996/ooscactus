
<div class="box-filter">
    <div class="b-head">
        <h2>پر مخاطب ترین محصولات</h2>
    </div>
    <div class="posts">
        @foreach ($popularProducts as $popularProduct)
        <div class="col">
                <a href="{{$popularProduct->path()}}">
                <div class="card-img"><img src="{{asset('/storage/' . $popularProduct->image)}}" alt="reactjs"></div>
                <div class="card-title"><h2>{{$popularProduct->title}}</h2></div>
                    <div class="card-body">
                        <img src="{{$popularProduct->sellerImage}}" alt="{{ $popularProduct->seller->name }}">
                        <span>{{ $popularProduct->seller->name }}</span>
                    </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
