@extends('Front::layout.master')
@section('content')
<main id="single">
  <div class="content">
    <div class="container">
        <article class="article">
            @include('Front::layout.header-ads')
            <div class="h-t">
                <h1 class="title">{{$article->title}}</h1>
                <div class="breadcrumb">
                    <ul>
                        <li><a href="/" title="خانه">خانه</a></li>
                        <li><a href="" title="مقالات">مقالات</a></li>
                        <li><a href="{{$article->path()}}" title="{{$article->title}}">
                                {$article->title}}</a></li>
                    </ul>
                </div>
            </div>
        </article>
    </div>

      <div class="main-row container">
          <div class="content article" style="width: 75%;  padding-left: 2%;">
              <div class="preview">
              <div class="course-description">
                  <div class="course-description-title">متن مقاله</div>
                  {!! $article->body !!}
                  <div class="tags">
                      <ul>
                          <li><a href="">کاکتوس بذری</a></li>
                          <li><a href="">کاکتوس تیغی</a></li>
                          <li><a href=""> ساکولنت</a></li>
                          <li><a href="">کاکتوس تزیینی</a></li>
                          <li><a href="">کاکتوس </a></li>
                          <li><a href="">گل های آپارتمانی</a></li>
                      </ul>
                  </div>
              </div>
          </div>
          </div>
          <div class="sidebar-right">
              <div class="sidebar-sticky">
                  <div class="product-info-box">
                      <div class="course-description">
                          <div>
                              @include('Front::layout.sidebar-banners')
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection
