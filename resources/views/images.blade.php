@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Add images</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="container">
                <div class="row">
                    <!-- Full Description & Specification -->
                    <div class="col-sm-12">
                        <div class="tabbable">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs product-details-nav">
                                <li class="active"><a href="#tab4" data-toggle="tab">Pictures</a></li>
                            </ul>
                            <!-- Tab Content (Full Description) -->
                            <div class="tab-content product-detail-info">
                                <div class="tab-pane active" id="tab4">
                                    <div id="fine-uploader-gallery"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Full Description & Specification -->
                    <br>

                        <button id="save" class="btn-success btn-lg pull-right">Finish uploading</button>
                        <div class="clearfix"></div>

                </div>
            </div>
        </div>
@endsection