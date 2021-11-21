@extends('Dashboard::maste')
@section('breadcrumb')
    <li><a href="{{ route('comments.index') }}" title="نظرات">نظرات </a></li>
    <li><a href="#" title="جزییات">جزییات </a></li>
@endsection
@section('content')
    <div class="main-content">
    <form class="form" action="{{route('comments.replyStore' , $comment->id)}}" method="post">
        @csrf
            <input type="hidden" name="parent_id" value="{{$comment->id}}">
            <input type="hidden" name="commentable_type" value="{{$comment->commentable_type}}">
            <input type="hidden" name="commentable_id" value="{{$comment->commentable_id}}">
            <div class="form-body">
                <div class="row">
                    <div class="col-12 col-12">
                        <div class="form-group">
                            <label for="country-floating">متن دیدگاه</label>
                            <textarea class="form-control" readonly id="basicTextarea"
                            rows="3" placeholder="متن دیدگاه">{{$comment->body}}</textarea>
                        </div>
                    </div>

                    <div class="col-12 col-12">
                        <div class="form-group">
                            <label for="country-floating">پاسخ</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="basicTextarea"
                                      rows="3" placeholder="پاسخ"></textarea>
                            @error('body')
                            <span class="invalid-feeadback" id="alert">
                        <strong>{{$message}}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-webamooz_net">ارسال پاسخ</button>
                        <a href="{{route('comments.index')}}" id="type-success" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">انصراف</a>
                    </div>
                </div>
            </div>
        </form>
        </div>
        @endsection
        @section('css')
            <link rel="stylesheet" href="/panel/app-assets/vendors/css/forms/select/select2.min.css">
        @endsection

        @section('js')
            <script src="/panel/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#categories').select2();
                });
            </script>
@endsection

