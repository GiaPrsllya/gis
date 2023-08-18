@extends('layout/secondLayout')

@section('title', 'Titik Rawan')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12">
                    <h3 class="font-weight-bold">Tentang</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>                    
        @endif
      </div>
        <div class="col-12">
            <div class="card">
              {{-- edit --}}
              <form action="/settings/" method="POST">
                @csrf
                <div class="card-body">
                  <h4 class="card-title">Address</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {{-- textarea --}}
                        <textarea required name="address" class="form-control" id="address" style="height: 120px" rows="4" placeholder="Enter Address">{{old('address',$settings['0']->option_value)}}</textarea>
                        {{-- <input required name="address" type="text" class="form-control" id="address" placeholder="Enter Address" value="{{old('address')}}"> --}}
                    
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input required name="email" type="email" class="form-control" id="email" placeholder="Enter email" value="{{old('email',$settings['1']->option_value)}}">
                    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                      <input required name="webaddress" type="text" class="form-control" id="webaddress" placeholder="Enter Web Address" value="{{old('webaddress',$settings['2']->option_value)}}">
                  
                      @error('webaddress')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Desc</h4>
                  <p class="lead">
                    <textarea required name="desc" class="form-control" id="desc" rows="4" placeholder="Enter Desc">{{old('desc',$settings['3']->option_value)}}</textarea>
                
                    @error('desc')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </p>

                  <button class="btn btn-primary" type="submit">Save</button>
                </div>
              </form>
            </div>
        </div>
    </div>



@endsection
