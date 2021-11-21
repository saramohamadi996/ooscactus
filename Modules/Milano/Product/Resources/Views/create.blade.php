
@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('products.index') }}" title="محصول ها">محصولات</a></li>
    <li><a href="#" title="ایجاد محصول">ایجاد محصول</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد محصول</p>
            <form action="{{ route('products.store') }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex multi-text">
                <x-input name="title" placeholder="عنوان محصول" type="text"  required/>
                <x-input type="text" name="slug" placeholder="نام پیوند(مفید برای سئو)" required/>
                </div>
                <x-input name="meta_description" placeholder="توضیح مختصر (مفید برای سئو) " type="text" required/>

                <div class="d-flex multi-text">
                    <x-input type="number" class="text-left mlg-15" name="priority" placeholder="ردیف محصول"/>
                    <x-input type="number" placeholder="مبلغ محصول" name="price" class="text-left" required/>
                    <x-input type="number" placeholder="درصد فروشنده" name="seller_share" class="text-left" required/>
                    <x-input type="number" placeholder="موجودی انبار " name="stock" class="text-left" required/>
                    <x-input type="text" placeholder="کد محصول" name="code_product" class="text-left" required/>
                </div>

{{--                <ul class="tags">--}}

{{--                    <li class="addedTag">dsfsdf<span class="tagRemove" onclick="$(this).parent().remove();">x</span>--}}
{{--                        <input type="hidden" value="dsfsdf" name="tags[]"></li>--}}
{{--                    <li class="addedTag">dsfsdf<span class="tagRemove" onclick="$(this).parent().remove();">x</span>--}}
{{--                        <input type="hidden" value="dsfsdf" name="tags[]"></li>--}}
{{--                    <li class="tagAdd taglist">--}}
{{--                        <input type="text" id="search-field">--}}
{{--                    </li>--}}
{{--                </ul>--}}

                <tag-select name="tags">

                <div class="d-flex multi-text">
                <select name="seller_id">
                    <option value="">انتخاب فروشنده محصول</option>
                    @foreach($sellers as $seller)
                        <option value="{{ $seller->id }}" @if($seller->id == old('seller_id')) selected @endif>{{ $seller->name }}</option>
                    @endforeach
                </select>

                <x-select name="status" required>
                    <option value="">وضعیت محصول</option>
                    @foreach(\Milano\Product\Models\Product::$statuses as $status)
                        <option value="{{ $status }}"
                                @if($status == old('status')) selected @endif>
                            @lang($status)</option>
                    @endforeach
                </x-select>

                    <x-select name="category_id" required>
                        <option value="">دسته بندی</option>
                        @foreach($categories  as $category)
                            <option value="{{ $category->id }}"
                                    @if($category->id == old('category_id')) selected @endif
                            >{{ $category->title }}</option>
                        @endforeach
                    </x-select>

                </div>
                <input type="file" name="images[]" required  multiple placeholder="تصویر محصول">
                <br>
                <textarea id="mytextarea" name="body"></textarea><br>
                <button class="btn btn-webamooz_net">ایجاد محصول</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
    <script src="{{asset('/panel/packages/tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    @include('Common::layouts.tinymce')


    <script src="/panel/js/tagsInput.js?v=12"></script>
    <script>
        $("#input").val()
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="/panel/css/bootstrap-tagsinput.css">
@endsection


