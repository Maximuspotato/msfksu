@extends('layouts.app')

@section('content')
    <!-- Homepage Slider -->
    {{-- <div class="homepage-slider">
        <div id="sequence">
            <ul class="sequence-canvas"> --}}
                <!-- Slide 1 -->
                {{-- <li class="bg4">
                    <!-- Slide Title -->
                    <h2 class="title">Welcome to KSU</h2>
                    <!-- Slide Text -->
                    <h3 class="subtitle">Logistic and procurement services</h3>
                </li> --}}
                <!-- End Slide 1 -->
                <!-- Slide 2 -->
                {{-- <li class="bg3 animate-in">
                    <!-- Slide Title -->
                    <h2 class="title">Welcome to KSU</h2>
                    <!-- Slide Text -->
                    <h3 class="subtitle">Regional logistic centre for the whole East Africa region</h3>
                </li>
                <!-- End Slide 2 -->
            </ul>
            <div class="sequence-pagination-wrapper">
                <ul class="sequence-pagination">
                    <li>1</li>
                    <li>2</li>
                </ul>
            </div>
        </div>
    </div> --}}
    <!-- End Homepage Slider -->

    <div class="section" style="padding-bottom: 0px">
        <div class="bg">
            <div class="container">
                <div class="row" style="padding-top:100px">
                    {{-- <div class="col-sm-4">
                        <img src="{{URL('/')}}/assets/img/warehouse.png" alt="">
                        <img class="door" src="{{URL('/')}}/assets/img/door.png" alt="">
                    </div> --}}
                    <div class="col-md-12 col-sm-12">
                        <h2>Welcome to KSU</h2>
                        <h3>Regional logistic centre for the whole East Africa region</h3>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="service-wrapper">
                            <img src="{{URL('/')}}/assets/img/service-icon/pills.png" alt="Service 1" height="60">
                            <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                            <h3>Full catalogue</h3>
                            <a href="{{URL('/catalogue?det=New')}}" class="btn">See more</a>
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
                            <a href="{{URL('/catalogue')}}" class="btn">See more</a>
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
    <div class="section">
        <div class="container">
            We hope you will enjoy using our App and find it useful. If you have suggestions feel free to contact <a href="{{URL('/contacts')}}">us</a>. We want to meet your needs and improve. That’s why we plan to add more features as we launch the second phase of our Web App. The main functionalities we already planned to have in the near future are:-<br>
            •	Items in the catalogue can be favorited <br>
            •	Registered users can access history of all items requested for quotation<br>
            •	Related items will be displayed when searching for a specific item<br>
            •	Supply news updates from all OC’s<br>
            •	Exploring ERP integration<br>
        </div>  
    </div>

    <!-- Services -->
    {{-- <div class="section">
        <div class="container">
            <h2 class="text-center">Catalogue</h2>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="service-wrapper">
                        <img src="{{URL('/')}}/assets/img/service-icon/popular.png" alt="Service 1">
                        <h3>Popular items</h3>
                        <a href="{{URL('/catalogue')}}" class="btn">See more</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="service-wrapper">
                        <img src="{{URL('/')}}/assets/img/service-icon/new.png" alt="Service 1">
                        <h3>Latest items</h3>
                        <a href="{{URL('/catalogue?det=New')}}" class="btn">See more</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="service-wrapper">
                        <img src="{{URL('/')}}/assets/img/service-icon/love.png" alt="Service 1">
                        <h3>Up for donation</h3>
                        <a href="{{URL('/catalogue?det=Donate')}}" class="btn">See more</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="service-wrapper">
                        <img src="{{URL('/')}}/assets/img/service-icon/pills.png" alt="Service 1">
                        <h3>Medical catalogue</h3>
                        <a href="{{URL('/catalogue?det=Med')}}" class="btn">See more</a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="service-wrapper">
                        <img src="{{URL('/')}}/assets/img/service-icon/camp.png" alt="Service 1">
                        <h3>Logistic catalogue</h3>
                        <a href="{{URL('/catalogue?det=Log')}}" class="btn">See more</a>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <a href="{{URL('/catalogue')}}" class="btn btn-lg centerin">See full catalogue</a>
            </div>
        </div>
    </div> --}}
    <!-- End Services -->
@endsection