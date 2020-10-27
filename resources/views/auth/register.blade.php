@extends('layouts.app')

@section('content')
<section class="vh-100 bg-soft d-flex align-items-center">
  <div class="container-fluid">
    <div
      class="row justify-content-center"
    >
      <div class="col-12 col-md-5 d-flex align-items-center justify-content-center">
        <div
          class="signin-inner mt-3 mt-lg-0 bg-white shadow-soft border border-light rounded p-4 p-lg-5 w-100 fmxw-500"
        >
          <div class="text-center text-md-center mb-4 mt-md-0">
            <h1 class="h3 font-weight-bold mb-3">{{ __('Register') }}</h1>
          </div>
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-user"></i>
                  </span>
                </div>
                <input
                  id="name" 
                  type="text" 
                  class="form-control @error('name') is-invalid @enderror" 
                  name="name" 
                  value="{{ old('name') }}" 
                  required 
                  autocomplete="name" 
                  autofocus
                  placeholder="{{ __('Name') }}"
                />
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-user"></i>
                  </span>
                </div>
                <input
                  id="email" 
                  type="email" 
                  class="form-control @error('email') is-invalid @enderror" 
                  name="email" 
                  value="{{ old('email') }}" 
                  required 
                  autocomplete="email"
                  placeholder="{{ __('E-Mail Address') }}"
                />
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-unlock-alt"></i>
                  </span>
                </div>
                <input 
                  id="password" 
                  type="password" 
                  class="form-control @error('password') is-invalid @enderror" 
                  name="password" 
                  required 
                  autocomplete="new-password" 
                  placeholder="{{ __('Password') }}"
                  />
                <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="far fa-eye"></i>
                  </span>
                </div>
                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="input-group mt-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-unlock-alt"></i>
                  </span>
                </div>
                <input
                  id="password-confirm" 
                  type="password" 
                  class="form-control" 
                  name="password_confirmation" 
                  required 
                  autocomplete="new-password"
                  placeholder="{{ __('Confirm Password') }}"
                />
              </div>
              <div class="d-block d-sm-flex justify-content-between align-items-center mt-2">
                <div class="form-group form-check mt-3">
                  <label class="text">
                    By clicking submit, you have agreed to the
                    <a target="_blank" href="/terms">terms and conditions</a>
                  </label>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-block btn-primary">{{ __('Register') }}</button>
            </div>
          </form>
          <!-- <div class="mt-3 mb-4 text-center">
            <span class="font-weight-normal">or</span>
          </div>
          <div class="btn-wrapper my-4 text-center">
            <button class="btn mr-2 btn-icon-only btn-pill btn-twitter" type="button">
              <span class="btn-inner-icon">
                <i class="fab fa-twitter"></i>
              </span>
            </button>
            <button class="btn mr-2 btn-icon-only btn-pill btn-facebook" type="button">
              <span class="btn-inner-icon">
                <i class="fab fa-facebook-f"></i>
              </span>
            </button>
            <button class="btn mr-2 btn-icon-only btn-pill btn-google" type="button">
              <span class="btn-inner-icon">
                <i class="fab fa-google"></i>
              </span>
            </button>
          </div> -->
          <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
            <span class="font-weight-normal">
              Already have an account?
              <a href="/login" class="font-weight-bold">Login here</a>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
