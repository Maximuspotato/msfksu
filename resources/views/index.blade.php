@extends('layouts.app')

@section('content')

    <div class="section" style="padding-bottom: 0px">
        <div class="bg">
            <div class="container">
                <div class="row" style="padding-top:100px">
                    <div class="col-md-12 col-sm-12">
                        <h2>Welcome to KSU</h2>
                        <h3>Regional logistic centre for the whole East Africa region</h3>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="service-wrapper">
                            <img src="{{URL('/')}}/assets/img/service-icon/pills.png" alt="Service 1" height="60">
                            <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                            <h3>Full catalogue</h3>
                            <a href="{{URL('/catalogue')}}" class="btn">See more</a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                            {{-- <img class="overlay" src="{{URL('/')}}/assets/img/soon.png" alt="" height="80"> --}}
                        <div class="service-wrapper disabled">
                            <img src="{{URL('/')}}/assets/img/service-icon/love.png" alt="Service 1">
                            <h3>Up for donation</h3>
                            <a href="{{URL('/catalogue')}}" class="btn">See more</a>
                            <h4 class="overlay" style="color:#F05E38"><b>COMING SOON!</b></h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="service-wrapper">
                            <img src="{{URL('/')}}/assets/img/service-icon/popular.png" alt="Service 1">
                            <h3 style="font-size: 1.2em; color: #53555c;">Popular items</h3>
                            <a href="{{URL('/catalogue?det=Popular')}}" class="btn">See more</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="service-wrapper">
                                <img src="{{URL('/')}}/assets/img/service-icon/megaphone.png" alt="Service 1">
                                <h3>Latest items</h3>
                                <a href="{{URL('/catalogue?det=New')}}" class="btn">See more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection