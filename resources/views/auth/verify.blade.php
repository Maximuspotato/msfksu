@extends('layouts.app')

@section('content')
<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Register</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Please wait while we verify you') }}</div>

                <div class="card-body">
                    {{-- @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __("We will send contact you within 24hrs. If don't and you should be verified, please contact us through our contacts page'") }}
                        </div>
                    @endif --}}

                    {{ __("We will contact you within 24hrs. If we don't and you should be verified, please contact us through our contacts page") }}
                    {{-- {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>. --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<br><br>