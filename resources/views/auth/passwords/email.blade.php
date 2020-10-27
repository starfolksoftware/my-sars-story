@extends('layouts.app')

@section('content')
<section class="vh-100 bg-soft d-flex align-items-center">
  <div class="container-fluid">
    <div
      class="row justify-content-center form-bg-image vh-100"
      data-background="../assets/img/illustrations/signin.svg"
      style="background-image: url('/images/auth_bg.jpg');"
    >
      <div class="col-12 col-md-5 d-flex align-items-center justify-content-center">
        <div
          class="signin-inner mt-3 mt-lg-0 bg-white shadow-soft border border-light rounded p-4 p-lg-5 w-100 fmxw-500"
        >
          <div class="text-center text-md-center mb-4 mt-md-0">
            <h1 class="mb-3 h3">{{ __('Reset Password') }}</h1>
            <p class="text-gray">An email will be sent to you with further instructions.</p>
          </div>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <form class="mt-5" method="POST" action="{{ route('password.email') }}">
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
            <div class="mt-3">
              <button type="submit" class="btn btn-block btn-primary">{{ __('Send Password Reset Link') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
