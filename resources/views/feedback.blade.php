@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Feedback</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSepal27e56EyeAq3hM4Og_XPiSFr_hwiuIvnbTOFZJG2yv7hQ/viewform" target="_blank">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <img src="{{URL('/')}}/assets/img/fb_wapp.png" alt="" height="80">
                                    </div>
                                    <div class="col-xs-10">
                                        <h3 class="card-title">Webapp feedback form</h3>
                                        <p class="card-text">With your input we would like to improve our WebApp</p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </a>
                </div>
                <div class="col-md-6 disabled">
                    <a href="">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <img src="{{URL('/')}}/assets/img/fb_ops.png" alt="" height="80">
                                    </div>
                                    <div class="col-xs-10">
                                        <h3 class="card-title">KSU Operations feedback form</h3>
                                        <p class="card-text" style="margin-bottom:0">You can help KSU to become better by sharing your ideas, suggestions, complaints, claims and complements etc.</p>
                                        <p style="color:red"><b>COMING SOON!</b></h4><p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection