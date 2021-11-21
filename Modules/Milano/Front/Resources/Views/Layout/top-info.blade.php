
<div class="top-info">
    @include('Front::layout.slider')
    <div class="optionals">
        @foreach($banners as $banner)
            <div><img src="{{'/storage/' . $banner->image}}"
             alt="{{$banner->title}}"><a href="{{$banner->link}}"></a></div>
        @endforeach
    </div>
</div>
