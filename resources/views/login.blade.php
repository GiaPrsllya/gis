@extends('layout/firstLayout')
@section('content')
<div class="row w-100 mx-0">
    <div class="col-lg-4 mx-auto">
      <div class="auth-form-light text-left py-5 px-4 px-sm-5">
        <div class="brand-logo">
          <img src="{{ asset('assets') }}/images/logo.svg" alt="logo">
        </div>
        <form class="pt-3">
          <div class="form-group">
            <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
          </div>
          <div class="form-group">
            <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
          </div>
          <div class="mt-3">
            <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="{{ url('dashboard') }}">SIGN IN</a>
          </div>
          <div class="my-2 d-flex justify-content-between align-items-center">
            <div class="form-check">
              <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input">
                Keep me signed in
              </label>
            </div>
            <a href="#" class="auth-link text-black">Forgot password?</a>
          </div>
          <div class="text-center mt-4 font-weight-light">
            Don't have an account? <a href="{{url('register')}}" class="text-primary">Create</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
