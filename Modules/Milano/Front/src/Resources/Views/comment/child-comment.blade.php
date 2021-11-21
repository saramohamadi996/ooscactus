@if(count($comment->child))
    @foreach($comment->child as $child)

        <div class="div-btn-answer">
            <a href="#mytextarea" class="replyComment btn-answer btn--comments-reply" data-commentID="{{ $child->id }}">پاسخ به دیدگاه</a>
        </div>

        <li class="is-answer">
            <div class="comment-header">
                <div class="comment-header-avatar">
                    <img src="{{$child->user->userImage}}">
                </div>
                <div class="comment-header-detail">
                    <div class="comment-header-name">مدیر سایت : {{$child->user->name}}</div>
                    <div class="comment-header-date">{{$child->JalaliCreatedAt}}</div>
                </div>
            </div>
            <div class="comment-content"><p>{{$child->body}}</p></div>
        </li>
    @endforeach
    @include('Front::comment.child-comment' , ['comment' => $child])
@endif
