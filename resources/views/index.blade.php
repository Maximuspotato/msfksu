@extends('layouts.app')

@section('content')

    <div class="section" style="padding-bottom: 0px">
        <div class="bg">
            <div class="container">
                <div class="row" style="padding-top:120px">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h2>Welcome to KSU</h2>
                                <h3>Supply Centre for the whole East Africa region</h3>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="service-wrapper" id="covid19">
                                    <img src="{{URL('/')}}/assets/img/service-icon/covid.png" alt="Service 1">
                                    <h3><span class="fas fa-exclamation-triangle">&nbsp;</span><b>COVID-19</b>&nbsp;<span class="fas fa-exclamation-triangle"></span></h3>
                                    <a href="{{URL('/covid19')}}" class="btn">See more</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="service-wrapper">
                                    <img src="{{URL('/')}}/assets/img/service-icon/pills.png" alt="Service 1" height="60">
                                    <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                                    <h3>Full catalogue</h3>
                                    <a href="{{URL('/catalogue')}}" class="btn">See more</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                    {{-- <img class="overlay" src="{{URL('/')}}/assets/img/soon.png" alt="" height="80"> --}}
                                <div class="service-wrapper">
                                    <img src="{{URL('/')}}/assets/img/service-icon/love.png" alt="Service 1">
                                    <h3>Up for donation</h3>
                                    <a href="{{URL('/exportDonations')}}" class="btn">See more</a>
                                    {{-- <h4 class="overlay" style="color:#F05E38"><b>COMING SOON!</b></h4> --}}
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="service-wrapper">
                                    <img src="{{URL('/')}}/assets/img/service-icon/popular.png" alt="Service 1">
                                    <h3 style="font-size: 1.2em; color: #53555c;">Popular items</h3>
                                    <a href="{{URL('/catalogue?det=Popular')}}" class="btn">See more</a>
                                </div>
                            </div>
                            {{-- <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="service-wrapper">
                                    <img src="{{URL('/')}}/assets/img/service-icon/megaphone.png" alt="Service 1">
                                    <h3>Latest items</h3>
                                    <a href="{{URL('/catalogue?det=New')}}" class="btn">See more</a>
                                </div>
                            </div> --}}
                            
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-left:0;">
                        <h5><b>MSF News</b></h5>
                        <div id="rss" >
                            
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    @if (AUTH::guest())
        <!-- Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Please register or log in to see prices and access supply related features.
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
                <div class="modal-footer">
                    <button type="button" class="btn-primary again" data-dismiss="modal">Don't show again</button>
                </div>
            </div>
            </div>
        </div>
    @endif
@endsection