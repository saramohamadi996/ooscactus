@if($child->subCategory->isNotEmpty())
    <ul class="dropdown-menu">
        @foreach ($child->subCategory as $sub_cat)
            <li class="{{count($sub_cat->subCategory) > 0 ? 'dropdown' : ''}}">
                <a href="{{$sub_cat->path()}}">{{$sub_cat->name}}</a>
                @include('Front::categories.child'  , ['child' => $sub_cat])
            </li>
        @endforeach
    </ul>
@endif
