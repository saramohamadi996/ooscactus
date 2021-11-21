@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('products.index') }}" title="محصولات">محصولات </a></li>
    <li><a href="#" title="ویرایش محصول">ویرایش محصول</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">بروزرسانی محصول</p>
            <form action="{{ route('products.update', $product->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="d-flex multi-text">
                <x-input name="title" placeholder="عنوان محصول" type="text" value="{{ $product->title }}" required/>
                <x-input type="text" name="slug" placeholder="نام پیوند(مفید برای سئو)" value="{{ $product->slug }}" class="text"/>
                </div>
                <x-input name="meta_description" placeholder="توضیح مختصر (مفید برای سئو) " type="text" value="{{ $product->meta_description }}" required/>


                <div class="d-flex multi-text">
                    <x-input type="number" class="text-left mlg-15" name="priority"
                             value="{{ $product->priority }}" placeholder="ردیف محصول"/>

                    <x-input type="number" placeholder="مبلغ محصول" name="price" class="text-left"
                             value="{{ $product->price }}" required />

                    <x-input type="number" placeholder="درصد فروشنده" name="seller_share"
                     class="text-left" value="{{ $product->seller_share }}" required />

                    <x-input type="number" placeholder="موجودی انبار" name="stock"
                     class="text-left" value="{{ $product->stock }}" required />

                    <x-input type="string" placeholder="کد محصول" name="code_product"
                     class="text-left" value="{{ $product->code_product }}" required />
                </div>

                {{--                <div class="col-md-6 col-12">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label for="last-name-column">برچسپ های محصول  </label>--}}
                {{--                        <input role="textbox"  InputMode="textarea" id="selectTags"  name="tag_name" value="@foreach($product->tags as $tag) {{$tag->tag_name}}  @endforeach">--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <x-tag-select name="tags"/>--}}
                <div class="d-flex multi-text">
                <x-select name="seller_id" required>
                    <option value="">انتخاب فروشنده محصول</option>
                    @foreach($sellers as $seller)
                        <option value="{{ $seller->id }}" @if($seller->id == $product->seller_id) selected @endif>{{ $seller->name }}</option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">وضعیت محصول</option>
                    @foreach(\Milano\Product\Models\Product::$statuses as $status)
                        <option value="{{ $status }}"
                                @if($status == $product->status) selected @endif>
                            @lang($status)</option>
                    @endforeach
                </x-select>

                <x-select name="category_id" required>
                    <option value="">دسته بندی</option>
                    @foreach($categories  as $category)
                        <option value="{{ $category->id }}"
                                @if($category->id == $product->category_id) selected @endif>
                            {{ $category->title }}</option>
                    @endforeach
                </x-select>
                </div>

                <div class="control-group form-group">
                    <div class="row">
                        <div class="col-12"  style="margin-top: 20px">
                            @foreach ($product->images as $image)
                                <img src="{{'/storage/' . $image->src}}" alt="" width="150">
                                <input type="radio" data-toggle="tooltip"  data-placement="bottom"
                                       data-original-title="انتخاب به عنوان عکس شاخص" name="main_image" id="" class="ml-3" value="{{$image->src}}"
                                       @if($image->main_image == 1) checked @endif>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="file" name="images[]" oninvalid="this.setCustomValidity('فیلد تصاویر محصول الزامی است')" multiple placeholder="تصویر محصول">

                <textarea id="mytextarea" name="body">{!! $product->body !!}</textarea>
                <br>
                <button class="btn btn-webamooz_net">بروزرسانی محصول</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
    <script src="{{asset('/panel/packages/tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    @include('Common::layouts.tinymce')
@endsection
