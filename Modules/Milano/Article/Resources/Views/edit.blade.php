
@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('articles.index') }}" title="مقالات">مقالات</a></li>
    <li><a href="#" title="ویرایش مقاله">ویرایش مقاله</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">ویرایش مقاله</p>
            <form action="{{ route('articles.update', $article->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="d-flex multi-text">
                <x-input name="title" placeholder="عنوان مقاله" type="text" value="{{ $article->title }}" required/>
                <x-input type="text" name="slug" placeholder="نام پیوند(مفید برای سئو)" value="{{ $article->slug }}" class="text-right" required />
                </div>

                <x-select name="category_id[]" id="">
                    @foreach( $categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </x-select>

                <div clsss="form-group"><img src="{{'/storage/' . $article->image}}"  width="80"></div>
                <input type="file" name="image" multiple placeholder="عکس مقاله">

                <textarea id="mytextarea" name="body">{!! $article->body !!}</textarea>
                <br>
                <button class="btn btn-webamooz_net">ویرایش مقاله</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
    <script src="{{asset('/panel/packages/tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    @include('Common::layouts.tinymce')
@endsection
