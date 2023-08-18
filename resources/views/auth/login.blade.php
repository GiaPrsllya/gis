@extends('layout/firstLayout')

@section('title', 'Login')

@section('content')
    <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-center py-5 px-4 px-sm-5">
                <div class="brand-logo">
                    <img src="{{ asset('assets') }}/images/logo.png" alt="logo">
                    <h5>DISHUB KABUPATEN SUBANG</h5>
                </div>
                <form method="POST" action="{{ route('login') }}" class="pt-3">
                    @csrf
                    <div class="form-group">
                        <input style="border-radius: 20px;" name="email" type="email"
                            class="form-control form-control-lg @error('email') is-invalid  @enderror "
                            id="exampleInputEmail1" placeholder="Masukan Email Anda">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input style="border-radius: 20px 0 0 20px;" name="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                id="exampleInputPassword1" placeholder="Masukan Password Anda">
                
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="mdi mdi-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit"
                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</a>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input">
                                Keep me signed in
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="auth-link text-black">Forgot password?</a>
                    </div>
                    {{-- <div class="text-center mt-4 font-weight-light">
                        Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
@endsection
