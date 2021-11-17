@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Our services</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/procurement.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Procurement and Purchasing</h3>
                            <p>
                                Local and international procurement of MSF approved medical and non-medical supplies
                            </p>
                        </div>
                    </div>
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/pharm.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Pharmacy</h3>
                            <p>
                                Medical manufacture and supplier validation and managing Good Distribution Practices [GDP]  
                            </p>
                        </div>
                    </div>
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/warehousing.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Warehousing</h3>
                            <p>
                                Reception, storage, dispatch of medical [i.e. Cold Chain, controlled, expires drugs], logistical supplies [e.g. dangers goods, electrical, mechanical] and consumables [e.g. stationary, cleaning]. KSU had 3 types of warehouse facilities in Nairobi: Transit Go Down [TGD], Export Processing Zone [EPZ] and an open warehouse
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/trans.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Stock management</h3>
                            <p>
                                Quality control, Inventory management, kitting, packing and labeling
                            </p>
                        </div>
                    </div>
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/transit.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Transport</h3>
                            <p>
                                Transit cargo management, cargo consolidation, local and international distribution of supplies by road, air and sea
                            </p>
                            <p>
                                @if (AUTH::guest())
                                    Click <a href="{{URL('/login')}}">here</a> for an overview of the regional transport rates 
                                @else
                                    Click <a href="{{URL('/downloadTransport')}}">here</a> for an overview of the regional transport rates 
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/customs.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Import / export</h3>
                            <p>
                                Clearing and forwarding of supplies purchased locally and internationally
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection