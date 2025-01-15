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
                                <h3 style="width: 75%">MSF Supply Kenya is the East African supply centre for Médecins Sans Frontières. Our MISSION is to provide high quality products and services that meet the needs of MSF, through the provision of regional supply activities (transit, regional & international procurement, stock pre-positioning)</h3>
                            </div>
                            
                            <div class="col-md-12 col-sm-12">
                                <br>
                                <div style="text-align: center;">
                                    <h3 style="border-radius: 25px;"><b>Our catalogue</b></h3>
                                </div><br>
                                <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 10px; margin-bottom:50px; opacity:95%;">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                      <li data-target="#myCarousel" data-slide-to="1"></li>
                                      <li data-target="#myCarousel" data-slide-to="2"></li>
                                      <li data-target="#myCarousel" data-slide-to="3"></li>
                                      <li data-target="#myCarousel" data-slide-to="4"></li>
                                    </ol>
                                
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                      
                                        <div class="row item active">
                                            <div style="text-align: center;">
                                                <h3><b style="background-color:gray">ENERGY</b></h3>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                                                    <h3>Solar</h3>
                                                    <ul style="color: black">
                                                        <li>Fronius Inverters</li>
                                                        <li>Phenix Inverters</li>
                                                        <li>Solar Items</li>
                                                        <li>Studer Inverters</li>
                                                        <li>Victron Inverters</li>
                                                    </ul>
                                                    {{-- <a href="{{URL('/catalogue')}}" class="btn">See more</a> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                                                    <h3>UPS</h3>
                                                    <ul style="color: black">
                                                        <li>Bluetti Power Stations</li>
                                                        <li>Delta UPS & stabilizers</li>
                                                        <li>Goal zero power station</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                                                    <h3>Generator</h3>
                                                    <ul style="color: black">
                                                        <li>FG Wilson</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                                                    <h3>Battery</h3>
                                                    <ul style="color: black">
                                                        <li>BYD Battery</li>
                                                        <li>Optima Battery</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row item">
                                            <div style="text-align: center;">
                                                <h3><b style="background-color:gray">WATSAN</b></h3>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/trans.png" height="60">
                                                    <h3>Incinerator construction material</h3>
                                                    <ul style="color: black">
                                                        <li>Incinerator construction material</li>
                                                    </ul>
                                                    {{-- <a href="{{URL('/catalogue')}}" class="btn">See more</a> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/trans.png" height="60">
                                                    <h3>Water filters</h3>
                                                    <ul style="color: black">
                                                        <li>Katadyn water filter</li>
                                                        <li>Lifestraw community</li>
                                                        <li>Tulip</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/trans.png" height="60">
                                                    <h3>Water quality</h3>
                                                    <ul style="color: black">
                                                        <li>DPD Tabs</li>
                                                        <li>Hanna combo water test</li>
                                                        <li>Palintest water test</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/trans.png" height="60">
                                                    <h3>Pumps</h3>
                                                    <ul style="color: black">
                                                        <li>Grundfos</li>
                                                        <li>Lorents</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row item">
                                            <div style="text-align: center;">
                                                <h3><b style="background-color:gray">SPAREPARTS</b></h3>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/transit.png" height="60">
                                                    <h3>Tractor</h3>
                                                    <ul style="color: black">
                                                        <li>Massey Ferguson</li>
                                                    </ul>
                                                    {{-- <a href="{{URL('/catalogue')}}" class="btn">See more</a> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/transit.png" height="60">
                                                    <h3>Car</h3>
                                                    <ul style="color: black">
                                                        <li>Toyota</li>
                                                        <li>Isuzu</li>
                                                        <li>Renault</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/transit.png" height="60">
                                                    <h3>Motorbike</h3>
                                                    <ul style="color: black">
                                                        <li>Honda</li>
                                                        <li>Yamaha</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/transit.png" height="60">
                                                    <h3>Generator</h3>
                                                    <ul style="color: black">
                                                        <li>FG Wilson</li>                                                    
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row item">
                                            <div style="text-align: center;">
                                                <h3><b style="background-color:gray">HVAC</b></h3>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/warehousing.png" height="60">
                                                    <h3>LG ACs</h3>
                                                    
                                                    {{-- <a href="{{URL('/catalogue')}}" class="btn">See more</a> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/warehousing.png" height="60">
                                                    <h3>S & P Ventillators</h3>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/warehousing.png" height="60">
                                                    <h3>Solar ACs</h3>
                                                   
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row item">
                                            <div style="text-align: center;">
                                                <h3><b style="background-color:gray">Building material</b></h3>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/procurement.png" height="60">
                                                    <h3>Insulation Material</h3>
                                                    <ul style="color: black">
                                                        <li>EPS Insulation material</li>
                                                        <li>PIR Insulation material</li>
                                                    </ul>
                                                    {{-- <a href="{{URL('/catalogue')}}" class="btn">See more</a> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/procurement.png" height="60">
                                                    <h3>Floor material</h3>
                                                    <ul style="color: black">
                                                        <li>Floor construction</li>
                                                        <li>Forbo floor construction</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="service-wrapper">
                                                    <img src="{{URL('/')}}/assets/img/service-icon/procurement.png" height="60">
                                                    <h3>General construction</h3>
                                                    <ul style="color: black">
                                                        <li>Roof construction material</li>
                                                        <li>Wall Construction</li>
                                                        <li>Doors</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                        </div>
                                      
                                    </div>
                                
                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                      <span class="glyphicon glyphicon-chevron-left"></span>
                                      <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                      <span class="glyphicon glyphicon-chevron-right"></span>
                                      <span class="sr-only">Next</span>
                                    </a>
                                  </div>
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