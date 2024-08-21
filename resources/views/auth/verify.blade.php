@extends('layouts.app')

@section('content')
<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Verify</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <br>
            <br>
            <div class="card text-center">
                <div class="card-header"><b>{{ __('Please wait while we verify you') }}</b></div>
                <br>
                <div class="card-body">
                    {{-- @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __("We will send contact you within 24hrs. If don't and you should be verified, please contact us through our contacts page'") }}
                        </div>
                    @endif --}}

                    {{ __("Your registration to MSF Supply Kenya Web App is being verified. We will contact you within one working day.
                    If you encounter any problems please don’t hesitate to contact us through our contact page.
                    ") }}
                    {{-- {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>. --}}
                </div>
            </div>
            <br>
            <br>
        </div>
    </div>
</div>
@endsection
<br><br>