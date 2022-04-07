@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Verify Emails</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            @if (count($users) > 0)
                
                @foreach ($users as $user)
                    <div id="verifycard" class="card" style="width: 50rem; height: max-content">
                        <div class="card-body">
                        <h5 class="card-title text-center">{{$user->id}}</h5>
                        <p class="card-text text-center">{{$user->email}}</p>
                        @foreach ($user_sects as $user_sect)
                            @if ($user->email == $user_sect->email)
                                <p class="card-text text-center">OC: {{$user_sect->oc}}</p>
                                <p class="card-text text-center">Country: {{$user_sect->country}}</p>
                            @endif
                        @endforeach
                        <div class="clearfix">
                            <a href="{{URL('/user-verify')}}?id={{$user->id}}" class="btn" style="background:cornflowerblue">Verify</a>
                            <a href="{{URL('/user-delete')}}?id={{$user->id}}" class="btn pull-right" style="background:crimson">Delete</a>
                        </div>
                        </div>
                    </div><br><hr><br>
                @endforeach

            @endif
        </div>
    </div>
@endsection