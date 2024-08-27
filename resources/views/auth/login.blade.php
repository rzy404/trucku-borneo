@extends('layouts.auth')
@section('title', 'Login Admin | TrucKu Borneo')
@section('content')
<div class="container h-100">
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-6">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <img src="{{ asset('images/icon/logo-full.png') }}" alt="">
                            </div>
                            <h4 class="text-center mb-4 text-white">{{session()->has('bahasa') ?
                                GoogleTranslate::trans("Sign in Your Account",
                                session()->get('bahasa')) : GoogleTranslate::trans("Sign in Your Account", 'id')}}
                            </h4>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="mb-1 text-white"><strong>{{ __('E-Mail') }}</strong></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="mb-1 text-white"><strong>{{ __('Password') }}</strong></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox ml-1 text-white">
                                            <input type="checkbox" class="custom-control-input" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember"> {{ __('Remember Me')
                                                }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-white text-primary btn-block">{{ __('Login')
                                            }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection