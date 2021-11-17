@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>CORONA VIRUS</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            {{-- This page is work in progress.<br>
            More information will follow.<br>
            <br>
            During these times we monitor our supply movements closely. Please refer to this <a href="{{URL('/downloadCovidUpdate')}}"><u>daily updated document</u></a> to read about the import & export situation in Kenya.
            <br><br> --}}
            @if (count($stories)>0)
                @foreach ($stories as $story)
                {{-- <div class="pull-right"><i>Last Updated: {{$story->date}} {{$story->time}}</i></div><br> --}}
                    {!! $story->details !!}
                @endforeach
            @endif 
        </div>
    </div>
@endsection