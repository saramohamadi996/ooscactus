{{--<form action="{{route('users.updateImage')}}" method="post" enctype="multipart/form-data">--}}
<form action="#" method="post" enctype="multipart/form-data">
    @csrf
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img">
{{--            <a href="{{ route('userImage.destroy', auth()->id() ) }}" class="item-delete mlg-15" title="حذف"></a>--}}
            <img   src="{{auth()->user()->userImage}}" class="avatar___img">
            <input type="file" name="image" accept="image" class="hidden avatar-img__input"
                   name="userPhoto" onchange="this.form.submit()">
            <div class="v-dialog__container" style="display: block;"></div>
                    <div class="box__camera default__avatar"></div>
        </div>
        <span class="profile__name">کاربر : {{auth()->user()->name}}</span>
    </div>

</form>
