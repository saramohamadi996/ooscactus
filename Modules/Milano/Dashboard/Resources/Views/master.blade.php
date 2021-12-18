<!DOCTYPE html>
<html lang="en">
@include('Dashboard::layout.head')
@livewireStyles
<body>
@include('Dashboard::layout.sidebar')
<div class="content">
    @include('Dashboard::layout.header')
    @include('Dashboard::layout.breadcrumb')
    <div class="main-content">
        @yield('content')
    </div>
</div>
<script src="{{asset('/panel/js/jquery-3.5.1.min.js')}}" ></script>
@include('Dashboard::layout.foot')
@stack('myscript')
@livewireScripts
</body>
</html>
