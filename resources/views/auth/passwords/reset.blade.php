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
            <h1 class="h3 font-weight-bold mb-3">{{ __('Reset Password') }}</h1>
          </div>
          <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
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
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-block btn-primary">{{ __('Reset Password') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
