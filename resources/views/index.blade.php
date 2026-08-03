@extends('layouts.app')

@section('content')

    <div class="section" style="padding-bottom: 0px">
        <div class="bg">
            <div class="container">
                <div class="row" style="padding-top:120px">
                    <div class="col-md-12">
                        <div class="row">
                            {{-- <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="service-wrapper" id="covid19">
                                    <img src="{{URL('/')}}/assets/img/service-icon/covid.png" alt="Service 1">
                                    <h3><span class="fas fa-exclamation-triangle">&nbsp;</span><b>COVID-19</b>&nbsp;<span class="fas fa-exclamation-triangle"></span></h3>
                                    <a href="{{URL('/covid19')}}" class="btn">See more</a>
                                </div>
                            </div> --}}
                            <div class="col-md-12 col-sm-12">
                                <h2>Welcome to MSF Supply Kenya</h2>
                                <h3 style="width: 75%">For more information about us, please visit <a href="https://msfintl.sharepoint.com/sites/grp-ocbksu-connect/MSF-Supply-Kenya/SitePages/Home.aspx">here</a></h3>
                                <h3 style="width: 75%">To access our Extranet, please visit <a href="{{URL('/extra_net')}}">here</a></h3>
                            </div>
                            
                            
                            
                            
                        </div>
                    </div>
                    {{-- <div class="col-md-2" style="padding-left:0;">
                        <h5><b>MSF News</b></h5>
                        <div id="rss" >
                            
                        </div>
                    </div> --}}
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
                        Not a member <span><a href="{{URL('/register')}}" class="btn">Register Now</a></span><span>&nbsp;&nbsp;</span><span><button type="button" class="btn-primary again" data-dismiss="modal">Register Later</button></span>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn-primary again" data-dismiss="modal">Don't show again</button> --}}
                </div>
            </div>
            </div>
        </div>
    @endif
@endsection