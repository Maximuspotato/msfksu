@extends('layouts.app')

@section('content')
    <!-- Page Title -->
        <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Login</h1>
                    </div>
                </div>
            </div>
        </div>

        @if (Session::has('reg'))
            <div class="section" style="background:greenyellow">
                <div class="container text-center">
                    Thank you for your registration! We welcoming you to our Web App. 
                    Your request is being processed and within one working day you will receive a verification email.
                    If you encounter any problems please don’t hesitate to <a href="{{URL('/contacts')}}">contact</a> us through our contact page.
                </div>
            </div>
        @endif
        
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="basic-login">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                            
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            
                                    <div class="col-md-6">
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <a class="pull-left" href="{{URL('/password/reset')}}">Forgot your password?</a>
                                        <button type="submit" class="btn btn-primary pull-right">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <div class="pull-left">
                            Not a member <span><a href="{{URL('/register')}}" class="btn">Register Now</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
@endsection
