
@if (isset($ads))
    <div class="ads">
        @foreach($ads as $ad)
            <a href="{{$ad->link}}" rel="nofollow noopener">
                <img src="{{'/storage/' . $ad->image}}" alt="{{$ad->title}}">
            </a>
        @endforeach
    </div>
    @endif


{{--    @foreach(\Milano\Ads\Models\Ads::where('page' , 'home')->get() as $ads)--}}
{{--    @if(\Milano\Ads\Models\Ads::$pages == \Milano\Ads\Models\Ads::PAGE_HOME)--}}
{{--        <div class="ads">--}}

{{--            <a href="{{\Milano\Ads\Models\Ads::first()->link}}" rel="nofollow noopener">--}}
{{--                <img src="{{'/storage/' . \Milano\Ads\Models\Ads::first()->image}}" alt="{{\Milano\Ads\Models\Ads::first()->title}}">--}}
{{--            </a>--}}

{{--        </div>--}}

{{--        @elseif(\Milano\Ads\Models\Ads::$pages == \Milano\Ads\Models\Ads::PAGE_SINGLE_PRODUCT)--}}


{{--    @endif--}}

{{--@if(\Milano\Ads\Models\Ads::$pages == \Milano\Ads\Models\Ads::PAGE_SINGLE_ARTICLE)--}}
{{--    <div class="ads">--}}

{{--        <a href="{{\Milano\Ads\Models\Ads::first()->link}}" rel="nofollow noopener">--}}
{{--            <img src="{{'/storage/' . \Milano\Ads\Models\Ads::first()->image}}" alt="{{\Milano\Ads\Models\Ads::first()->title}}">--}}
{{--        </a>--}}

{{--    </div>--}}
{{--@endif--}}

{{--@if(\Milano\Ads\Models\Ads::$pages == \Milano\Ads\Models\Ads::PAGE_SINGLE_PRODUCT)--}}
{{--    <div class="ads">--}}

{{--        <a href="{{\Milano\Ads\Models\Ads::first()->link}}" rel="nofollow noopener">--}}
{{--            <img src="{{'/storage/' . \Milano\Ads\Models\Ads::first()->image}}" alt="{{\Milano\Ads\Models\Ads::first()->title}}">--}}
{{--        </a>--}}

{{--    </div>--}}
{{--@endif--}}

{{--    @endforeach--}}

{{--    @if(\Milano\Ads\Models\Ads::$pages == \Milano\Ads\Models\Ads::PAGE_SINGLE_PRODUCT)--}}
{{--        <div class="ads">--}}

{{--            <a href="{{$ads->link}}" rel="nofollow noopener">--}}
{{--                <img src="{{'/storage/' . $ads->image}}" alt="{{$ads->title}}">--}}
{{--            </a>--}}

{{--        </div--}}
{{--    @endif--}}


{{--    @if(\Milano\Ads\Models\Ads::$pages == 'single_article')--}}
{{--        <div class="ads">--}}

{{--            <a href="{{$ads->link}}" rel="nofollow noopener">--}}
{{--                <img src="{{'/storage/' . $ads->image}}" alt="{{$ads->title}}">--}}
{{--            </a>--}}

{{--        </div--}}
{{--    @endif--}}
{{--    @endforeach--}}
