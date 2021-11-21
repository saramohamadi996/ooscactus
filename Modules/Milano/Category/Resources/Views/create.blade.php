

<p class="box__title">ایجاد دسته بندی جدید</p>
<form action="{{ route('categories.store') }}" method="post" class="padding-30">
    @csrf

    <x-input type="text" name="title"  placeholder="نام دسته بندی" required/>
    <x-input type="text" name="slug"  placeholder="نام پیوند(مفید برای سئو)" required/>

    <p class="box__title margin-bottom-15">انتخاب والد</p>
    <x-select name="parent_id" id="parent_id">
        <option value="">ندارد</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
    </x-select>
    <button class="btn btn-webamooz_net">اضافه کردن</button>
</form>
