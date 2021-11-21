
<div class="sidebar-banners">
    @foreach($baners as $baner)
    <div class="sidebar-pic">
        <a href="{{$baner->link}}">
            <img src="{{'/storage/' . $baner->image}}" alt="{{$baner->title}}">
        </a>
    </div>
    @endforeach
</div>
