@extends('layouts.app')
@php
    $active = "";
@endphp
@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>STOP RIGHT THERE!!! THERE'S NOTHING TO SEE HERE!!!!</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                <img src="{{URL('/')}}/assets/img/404.jpg" alt="">
                <br><br>
                <h5>Seems like something went wrong or you encountered an error! Go back our Homepage by clicking the button below before you get SCRATCHED!!</h5>
                <a class="btn" href="{{URL('/')}}">I've seen enough, please take me back to safety</a>
            </div>
        </div>
    </div>
@endsection