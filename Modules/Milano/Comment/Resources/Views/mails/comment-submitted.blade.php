
@component('mail::message')
    # یک کامنت جدید برای دوره ی"{{ $comment->commentable->title }}" ارسال شده است.
    فروشنده گرامی یک کامنت جدید برای دوره ی"{{ $comment->commentable->title }}" در سایت اوس کاکتوس ارسال شده است. لطفا در اسرع وقت پاسخ مناسب ارسال فرمایید.
    @component('mail::panel')
        @component('mail::button', ['url' => $comment->commentable->path()])
            مشاهده محصول
        @endcomponent
    @endcomponent

    با تشکر.{{ config('app.name') }}
@endcomponent
