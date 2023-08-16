@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Downloads and General information</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 faq-wrapper">
                    <div class="panel-group" id="accordion2">
                        {{-- <h3>Downloads <span class="pull-right" style="font-size:16px">Last Updated</span></h3> --}}
                        {{-- <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse21">
                                    Catalogue
                                </a>
                                <span class="pull-right">24/01/2020</span>
                            </div>
                            <div id="collapse21" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    @if (AUTH::guest())
                                        <p><a href="{{URL('/login')}}">Full catalogue.xlxs</a></p>
                                    @else
                                        <p><a href="{{URL('/download?dwnld=full')}}">Full catalogue.xlxs</a></p> 
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse22">
                                    Unifield supplier catalogue
                                </a>
                                <span class="pull-right">24/01/2020</span>
                            </div>
                            <div id="collapse22" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    @if (AUTH::guest())
                                        <p><a href="{{URL('/login')}}">KSU catalogue.xlxs</a></p> 
                                    @else
                                        <p><a href="{{URL('/download?dwnld=ksu')}}">KSU catalogue.xlxs</a></p>  
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse23">
                                    Regional transport rates
                                </a>
                                {{-- <span class="pull-right">24/02/2020</span> --}}
                            </div>
                            <div id="collapse23" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    @if (AUTH::guest())
                                        <p><a href="{{URL('/login')}}">KSU Regional Transport  Rates.xlsx</a></p> 
                                    @else
                                        <p><a href="{{URL('/downloadTransport')}}">KSU Regional Transport  Rates.xlsx</a></p>  
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse24">
                                    Terms & conditions
                                </a>
                            </div>
                            <div id="collapse24" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    @if (AUTH::guest())
                                        <p><a href="{{URL('/login')}}">Kenya Supply Unit-Terms-of-Conditions.pdf</a></p>
                                    @else
                                        <p><a href="{{URL('/dwnlds?dwnld=tc')}}">Kenya Supply Unit-Terms-of-Conditions.pdf</a></p> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection