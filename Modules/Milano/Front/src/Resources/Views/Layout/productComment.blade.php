<div class="container">
    @auth
        <div class="comments">
            <div class="comment-main">
                <div class="ct-header" class="biyainja">
                    <h3>نظرات ( {{count($product->comments)}} )</h3>
                    <p>نظر خود را در مورد این محصول مطرح کنید</p>
                </div>
                <div class="ct-row">
                    <div class="ct-textarea">
                        <textarea  id="mytextarea" name="body" class="txt ct-textarea-field btn--comments-reply"></textarea>
                    </div>
                </div>
                <div class="ct-row">
                    <input type="hidden" name="parent_id">
                    <div class="send-comment">
                        <button id="ajax-sub" class="btn i-t">ثبت نظر</button>
                    </div>
                </div>
            </div>
            <div class="comments-list">
                @foreach($product->comments->where('parent_id' , null) as $comment)
                    <ul class="comment-list-ul">
                        <li class="is-comment">
                            <div class="comment-header">
                                <div class="comment-header-avatar"><img src="{{$comment->user->userImage}}"></div>
                                <div class="comment-header-detail">
                                    <div class="comment-header-name">کاربر :{{$comment->user->name}}</div>
                                    <div class="comment-header-date">{{$comment->JalaliCreatedAt}}</div>
                                </div>
                            </div>
                            <div class="comment-content"><p>{{$comment->body}}</p></div>
                        </li>
                        @include('Front::comment.child-comment' ,['comment' => $comment])
                        <div class="div-btn-answer">
                            <a href="#mytextarea" id="buttonss" class="replyComment btn-answer btn--comments-reply" data-commentID="{{ $comment->id }}">پاسخ به دیدگاه</a>
                        </div>
                    </ul>
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-dager"><a href="{{route('login')}}">برای ارسال پاسخ باید توی سایت لاگین کنید</a></div>
    @endauth
</div>
@section('js')
    <script>
        $(document).ready(function(){

            $('.replyComment').on('click' , function () {
                let id = $(this).attr('data-commentID');
                $('input[name="parent_id"]').val(id);

            });
            $('#ajax-sub').click(function(e){
                if($("#mytextarea").val().length == 0){
                    alert('متن دیدگاه کوتاه است')
                }
                $.ajax({
                    url: "{{route('comment.product' , $product->id)}}",
                    method: 'post',
                    data: {
                        body: $('#mytextarea').val(),
                        parent_id: $('input[name="parent_id"]').val(),
                        _token: "{{ CSRF_TOKEN() }}"
                    },
                    success: function(result){
                        document.getElementById("mytextarea").value = "";
                        $('input[name="parent_id"]').val('');
                        // alert('نظر شما با موفقیت ارسال شد.');
                    }});
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.btn--comments-reply[href^="#"]').on('click',function (e) {
                e.preventDefault();
                let target = this.hash;
                let $target = $(target);
                $('html, body').animate({
                    'scrollTop': $target.offset().top -250
                }, 900, 'swing', function () {
                    // window.location.hash = target;
                });
            });
        });
    </script>
@endsection

