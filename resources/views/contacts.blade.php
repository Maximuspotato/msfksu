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
                        <iframe width="652" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=-1.3234318%2C%2036.8509436&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"></iframe>
                    </div>
                    <!-- End Map -->
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
                <div class="col-sm-6">
                @if (AUTH::guest())
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            MSF Supply Kenya Support<br>
                            <a href="mailto:Support.MSFSUPPLYKE@brussels.msf.org">Support.MSFSUPPLYKE@brussels.msf.org</a><br>
                            {{-- Tel +254 (0) 20 354 2419 --}}
                        </p>
                    </div>
                @else
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Customer Service<br>
                            <a href="mailto:CustomerService.MSFSUPPLYKE@brussels.msf.org">CustomerService.MSFSUPPLYKE@brussels.msf.org</a><br>
                            Tel +254 (0) 794 655 262
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Transport Manager<br>
                            <a href="mailto:TransportManager.MSFSUPPLYKE@brussels.msf.org">TransportManager.MSFSUPPLYKE@brussels.msf.org</a><br>
                            Tel +254 (0) 710 809 156
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            General Manager<br>
                            <a href="mailto:antoine.segui@brussels.msf.org">Antoine.Segui@brussels.msf.org</a><br>
                            Tel +254 (0) 719 898 615
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            HR Manager<br>
                            <a href="mailto:phyllis.koech@brussels.msf.org">Phyllis.Koech@brussels.msf.org</a><br>
                            Tel +254 (0) 705 000 570
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Finance Coordinator<br>
                            <a href="mailto:yannick.remans@brussels.msf.org">Yannick.Remans@brussels.msf.org</a><br>
                            Tel +254 (0) 717 119 065
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Supply Chain Manager<br>
                            <a href="mailto:Justine.Mecha@brussels.msf.org">Justine.Mecha@brussels.msf.org</a><br>
                            Tel +254 (0) 703 688 612
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Responsible Pharmacist<br>
                            <a href="mailto:muthoni.mulinge@brussels.msf.org">Muthoni.Mulinge@brussels.msf.org</a><br>
                            Tel +254 (0) 700 700 562
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Procurement Manager<br>
                            <a href="mailto:paul.banks@brussels.msf.org">Paul.Banks@brussels.msf.org</a><br>
                            Tel +254 (0) 740 753 376
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Product Referent<br>
                            <a href="mailto:aluda.duncan@brussels.msf.org">Aluda.Duncan@brussels.msf.org</a><br>
                            Tel +254 (0) 794 655 263
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p class="contact-us-details">
                            Fuctional Analyst<br>
                            <a href="mailto:lewis.mwathe@brussels.msf.org">Lewis.Mwathe@brussels.msf.org</a><br>
                            Tel +254 (0) 759 014 775
                        </p>
                    </div>
                @endif
                </div>
                <div class="col-sm-6">
                    <p class="contact-us-details">
                        MSF Supply Kenya<br>
                        Memkam Complex, Unit 1<br>
                        Road C off enterprise Road, Near Winners Chapel<br/>
                        P.O. Box 38897 – 00623<br/>
                        Nairobi, Kenya<br/>
                        {{-- Telephone +254 (0)20 354 2419 --}}
                    </p>
                </div>
                
            </div>
        </div>
    </div>
@endsection