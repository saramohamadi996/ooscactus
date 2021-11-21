@extends('auth.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تایید رمز عبور</div>

                <div class="card-body">
                   لطفا ابتدا پسورد خود را تایید کنید و سپس ادامه دهید.

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">رمز عبور</label>

                            <div class="col-md-6">
                                <x-input id="password" type="password" class="form-control" name="password" required autocomplete="current-password"/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">تایید رمز عبور</button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">رمز عبور خود را فراموش کرده اید؟</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
