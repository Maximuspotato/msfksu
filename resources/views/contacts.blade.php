@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Contact Us</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <!-- Map -->
                    {{-- <div id="contact-us-map">
                        
                    </div> --}}
                    <div id="map" >
                        <iframe width="652" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=-1.3278%2C%2036.866&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"></iframe>
                    </div>
                    <!-- End Map -->
                    <!-- Contact Info -->
                    <p class="contact-us-details">
                        MSF Kenya Supply Unit<br>
                        Road C off enterprise Road<br>
                        Sameer Industrial Park<br/>
                        P.O. Box 38897 – 00623<br/>
                        Nairobi, Kenya<br/>
                        Telephone +254 (0)20 354 2419<br>
                        <br>
                        KSU Customer Service<br>
                        <a href="MSFOCB-KSU-CustomerService@brussels.msf.org">MSFOCB-KSU-CustomerService@brussels.msf.org</a><br>
                        Cell +254 (0)<br>
                        <br>
                        KSU HR Manager<br>
                        <a href="MSFOCB-KSU-Admin@brussels.msf.org">MSFOCB-KSU-Admin@brussels.msf.org</a><br>
                        Cell +254 (0) 705 000 570<br>
                        <br>
                        KSU General Manager<br>
                        <a href="MSFOCB-KSU-Coord@brussels.msf.org">MSFOCB-KSU-Coord@brussels.msf.org</a><br>
                        Cell +254 (0) 722 509 964
                    </p>
                    <!-- End Contact Info -->
                </div>
                <div class="col-sm-5">
                    <!-- Contact Form -->
                    <h3>Send Us a Message</h3>
                    <div class="contact-form-wrapper">
                        <form class="form-horizontal" role="form">
                                <div class="form-group">
                                <label for="Name" class="col-sm-3 control-label"><b>Your name</b></label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="Name" type="text" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact-email" class="col-sm-3 control-label"><b>Your Email</b></label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="contact-email" type="text" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact-message" class="col-sm-3 control-label"><b>Message</b></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="5" id="contact-message"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn pull-right">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End Contact Info -->
                </div>
            </div>
        </div>
    </div>
@endsection