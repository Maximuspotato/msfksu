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
                                <img src="{{URL('/')}}/assets/img/service-icon/popular.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Partial Order Confirmation: Alignment with ESC frame to treat orders</h3>
                            <p>As you may know, the ESCs are sending partial order confirmation. This way, we would avoid losing too much time on confirming an entire order while only few lines are pending</p>
                            <p>To make sure that you keep an entire overview of your initial request, you can access our Extranet (please contact us if you face any challenges or need some guidance for the first time) to the overview of the entire PO/RFQ</p>
                        </div>
                    </div>
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/popular.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Standard List</h3>
                            <p>In order to be proactive, we are updating continuously MSF Supply Kenya Standard List. This list is dynamic and you can access on the website and in Unicat</p>
                            <p>You have a column with indication about pricing. Some items have a defined price (already negotiated with the supplier), some would hold only an indicative price (based on a purchase done in past 3 month) and some would have no price (meaning not purchased in past 3 months and no agreement with a supplier)</p>
                            <p>For the items not in the Standard List, we welcome your request and will work on it to provide you feedback about our capacity (specification of the products)</p>
                        </div>
                    </div>
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
                                Reception, storage, dispatch of medical [i.e. Cold Chain, controlled, expires drugs], logistical supplies [e.g. dangers goods, electrical, mechanical] and consumables [e.g. stationary, cleaning]. MSF Supply Kenya had 3 types of warehouse facilities in Nairobi: Transit Go Down [TGD], Export Processing Zone [EPZ] and an open warehouse
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/popular.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Commitment on Lead-Time</h3>
                            <p>For the items in the Standard List, we will send you an Order Confirmation (ORC) within 5 working days</p>
                            <p>For the items not in the Standard list, we will send you a feedback (ORC with detailed specification) within 10 working days</p>
                            <p>Please note that in the ORC, you will have information about price but also Lead-time to put the items in Ready To Ship zone</p>
                            <br><br>
                        </div>
                    </div>
                    <div class="row service-wrapper-row">
                        <div class="col-sm-4">
                            <div class="service-image">
                                <img src="{{URL('/')}}/assets/img/service-icon/popular.png" alt="Service Name" height="80">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3>Order Confirmation validity</h3>
                            <p>
                                Considering the dynamic market in which we are working in, we need you to confirm the ORC as quick as possible. For this reason, we expect to have a validation of the ORC within 2 weeks from the day you receive the ORC
                            </p>
                            <p>We will send you a first reminder after one week. If no feedback after 10 days, we will send you a final reminder informing you that the order will be cancelled in the coming days</p>
                            <p>In case, you are in the final process of validation and need more than 2 weeks, please inform us so we can try our best to maintain the condition mentioned in the ORC. Unfortunately, we can’t guarantee that we will be successful</p>
                        </div>
                    </div>
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
                                    Click <a href="{{URL('/login')}}">here</a> for an overview of the regional transport rates and <a href="{{URL('/login')}}">here</a> to see the countries we ship to
                                @else
                                    Click <a href="{{URL('/downloadTransport')}}">here</a> for an overview of the regional transport rates and <a id="trButt">here</a> to see the countries we ship to
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
        <div class="container">
            <img src="{{URL('/')}}/assets/img/flow.png" alt="" width="100%">
        </div>
    </div>

    <div class="modal fade in" id="trModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Countries we ship to</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="basic-login">
                    <img src="{{URL('/')}}/assets/img/countriestr.PNG" alt="">
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection