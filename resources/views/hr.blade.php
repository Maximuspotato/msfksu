@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Open Vacancies</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                No open positions. Make sure to come back because we are always looking for someone to add to our amazing team:)
                <!-- Open Vacancies List -->
                {{-- <div class="col-md-8">
                    <table class="jobs-list">
                        <tr>
                            <th>Position</th>
                            <th>Type</th>
                        </tr>
                        <tr>
                            <!-- Position -->
                            <td class="job-position">
                                <a href="{{URL('/dwnlds?dwnld=jobo')}}">Medical Intern</a> <span class="label label-danger">New</span>
                            </td>
                            <!-- Job Type -->
                            <td class="job-type hidden-phone">INTERNSHIP</td>
                    </table>
                </div> --}}
                <!-- End Open Vacancies List -->
                <!-- Sidebar -->
                {{-- <div class="col-md-4 col-sm-6">
                    <div class="join-us-promo">
                        <!-- Quote -->
                        <div class="join-us-bubble">
                            <blockquote>
                                <p class="quote">
                                    "You are very welcome in our team! Ut enim ad minim veniam, quis nostrud exercitation."
                                </p>
                            </blockquote>
                        </div>
                    </div>
                </div> --}}
                <!-- End Sidebar -->
            </div>
        </div>
    </div>
@endsection