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
                        {{-- <h3>Reports</h3>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse11">
                                    KPI 2019
                                </a>
                            </div>
                            <div id="collapse11" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="">kpi.pdf</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse12">
                                    KPI 2018
                                </a>
                            </div>
                            <div id="collapse12" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="">kpi.pdf</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse13">
                                    KPI 2017
                                </a>
                            </div>
                            <div id="collapse13" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="">kpi.pdf</a></p>
                                </div>
                            </div>
                        </div> --}}
                        <h3>Downloads</h3>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse21">
                                    Catalogue
                                </a>
                            </div>
                            <div id="collapse21" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="{{URL('/download?dwnld=full')}}">Full catalogue.xlxs</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse22">
                                    Unifield supplier catalogue
                                </a>
                            </div>
                            <div id="collapse22" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a href="{{URL('/download?dwnld=ksu')}}">KSU catalogue.xlxs</a></p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse22">
                                    Policies
                                </a>
                            </div>
                            <div id="collapse22" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p><a>Policies.doc</a></p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection