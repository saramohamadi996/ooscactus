@extends('Front::layout.master')
@section('content')
<main id="index">
    <article class="container article">
        <div class="box-filter">
            <br><div class="b-head"><h2> همه مقالات</h2></div>
            <div class="articles">
            @foreach($articles as $article)
                <div class="col">
                     <a href="{{$article->path()}}">
                    <div class="card-img"><img src="{{'/storage/' . $article->image}}" alt="reactjs"></div>
                    <div class="card-title"><h2>{{$article->title}}</h2></div>
                    <div class="card-body"></div>
                    <div class="card-details">
                        <span class="b-view">{{$article->viewCount ?? '0'}}</span>
                        <span class="b-category">
                                @foreach($article->categories as $category)دسته بندی :{{$category->title}}@endforeach
                        </span>
                    </div>
                </a>
               </div>
            @endforeach
            </div>
        </div>
    </article>
<main id="single">
@endsection
