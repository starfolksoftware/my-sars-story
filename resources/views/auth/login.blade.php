@extends('layouts.app')

@section('content')
<section class="vh-100 bg-soft d-flex align-items-center">
  <div class="container-fluid">
    <div
      class="row justify-content-center form-bg-image vh-100"
    >
      <div class="col-12 col-md-5 d-flex align-items-center justify-content-center">
        <div
          class="signin-inner mt-3 mt-lg-0 bg-white shadow-soft border border-light rounded p-4 p-lg-5 w-100 fmxw-500"
        >
          <div class="text-center text-md-center mb-4 mt-md-0">
            <h1 class="mb-3 h3">Sign in</h1>
            <p class="text-gray">Use your credentials to access your account.</p>
          </div>
          <form class="mt-5" method="POST" action="{{ route('login') }}">
          @csrf
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
                  autofocus
                  placeholder="{{ __('Password') }}"
                />
                @error('password')
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
                  autocomplete="current-password"
                  placeholder="{{ __('E-Mail Address') }}" />
                <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="far fa-eye"></i>
                  </span>
                </div>
              </div>

              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              <div class="d-block d-sm-flex justify-content-between align-items-center mt-2">
                <div class="form-group form-check mt-3">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                  <label
                    class="form-check-label form-check-sign-white"
                    for="remember"
                  >{{ __('Remember Me') }}</label>
                </div>
                <div>
                  @if (Route::has('password.request'))
                    <a class="small text-right" href="{{ route('password.request') }}">
                      {{ __('Forgot Your Password?') }}
                    </a>
                  @endif
                </div>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-block btn-primary">{{ __('Login') }}</button>
            </div>
          </form>
          <!-- <div class="mt-3 mb-4 text-center">
            <span class="font-weight-normal">or login with</span>
          </div>
          <div class="btn-wrapper my-4 text-center">
            <button class="btn btn-icon-only btn-twitter mr-2" type="button">
              <span>
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
          </div>
          <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
            <span class="font-weight-normal">
              Not registered?
              <a href="" class="font-weight-bold">{{ __('Register') }}</a>
            </span>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
