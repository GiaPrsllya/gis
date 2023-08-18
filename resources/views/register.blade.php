@extends('layout/firstLayout')

@section('content')
<div class="row w-100 mx-0">
    <div class="col-lg-4 mx-auto">
      <div class="auth-form-light text-left py-5 px-4 px-sm-5">
        <div class="brand-logo">
          <img src="{{ asset('assets')}}/images/logo.svg" alt="logo">
        </div>
        <form class="pt-3">
          <div class="form-group">
            <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username">
          </div>
          <div class="form-group">
            <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
          </div>
          <div class="form-group">
            <select class="form-control form-control-lg" id="exampleFormControlSelect2">
              <option>Country</option>
              <option>United States of America</option>
              <option>United Kingdom</option>
              <option>India</option>
              <option>Germany</option>
              <option>Argentina</option>
            </select>
          </div>
          <div class="form-group">
            <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
          </div>
          <div class="mb-4">
            <div class="form-check">
              <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input">
                I agree to all Terms & Conditions
              </label>
            </div>
          </div>
          <div class="mt-3">
            <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN UP</a>
          </div>
          <div class="text-center mt-4 font-weight-light">
            Already have an account? <a href="{{url('login')}}" class="text-primary">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection