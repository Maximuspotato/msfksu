@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Extranet</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 faq-wrapper">
                    <div class="panel-group" id="accordion2">
                        <h3>Extranet reports</h3>
                        {{-- <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse24">
                                    Client
                                </a>
                            </div>
                            <div id="collapse24" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="{{URL('/rts')}}">RTS Report</a></p>
                                    <p><a href="{{URL('/stock')}}">Stock Report</a></p>
                                    <p><a href="{{URL('/rts-value')}}">RTS Value Report</a></p>
                                    <p><a href="{{URL('/batch-traceability')}}">Batch Traceability</a></p>
                                </div>
                            </div>
                        </div> --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse21">
                                    Orders
                                </a>
                            </div>
                            <div id="collapse21" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="{{URL('/bo-monitoring')}}">Backorder Monitoring</a></p>
                                    <p><a href="{{URL('/order-confirmation')}}">Order Confirmation</a></p>
                                    <p><a href="{{URL('/order-view')}}">Order View</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse22">
                                    Transport
                                </a>
                            </div>
                            <div id="collapse22" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="{{URL('/tr-overview')}}">Transport Overview</a></p>
                                    <p><a href="{{URL('/pk-overview')}}">Packing Overview</a></p>
                                    <p><a href="{{URL('/tr-packing')}}">Transport Cost Per Packing</a></p>
                                    <p><a href="{{URL('/packing-view')}}">Packing View</a></p>
                                    <p><a href="{{URL('/freight-view')}}">Freight View</a></p>
                                    <p><a href="{{URL('/dnno-view')}}">Dn no view</a></p>
                                    <p><a href="{{URL('/awb-view')}}">AWB view</a></p>
                                    <p><a href="{{URL('/cmr-view')}}">CMR view</a></p>
                                    <p><a href="{{URL('/freight-reception')}}">Freight reception</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse23">
                                    Finance
                                </a>
                            </div>
                            <div id="collapse23" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="{{URL('/invoice')}}">Invoice pdf</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse24">
                                    Search
                                </a>
                            </div>
                            <div id="collapse24" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="{{URL('/documents')}}">Documents</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection