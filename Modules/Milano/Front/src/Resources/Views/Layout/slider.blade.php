
<div class="slideshow">
    @foreach($sliders as $slider)
    <div class="slide"><img src="{{'/storage/' . $slider->image}}"
     alt="{{$slider->title}}"><a href="{{$slider->link}}"></a></div>
    @endforeach
    <a class="prev" onclick="move(-1)"><span>&#10095</span></a>
    <a class="next" onclick="move(1)"><span>&#10094</span></a>

    <div class="items">
        <div class="item"><div class="item-inner"></div></div>
        <div class="item"><div class="item-inner"></div></div>
        <div class="item"><div class="item-inner"></div></div>
        <div class="item"><div class="item-inner"></div></div>
        <div class="item"><div class="item-inner"></div></div>
    </div>
</div>
