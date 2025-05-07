@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>WMS Dahsboard</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            @php
                $fullemail = Auth::user()->email;
                $fullname = str_replace("."," ",$fullemail);
                $email = substr($fullname, 0, strpos($fullname, "@"));
            @endphp
            <h2>Welcome {{$email}}</h2>
            @if (strtoupper(Auth::user()->email) == "WHSE.SUPERVISOR@BRUSSELS.MSF.ORG")
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Upload file</h3>
                        <form action="{{URL('/uploadPick')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" required><br>
                            <select name="picker" id="picker" required>
                                <option value="WHSE PICKER1">WHSE PICKER1</option>
                                <option value="WHSE PICKER2">WHSE PICKER2</option>
                            </select><br><br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h3>Overview files</h3>
                        @foreach ($filenames as $filename)
                            <a href="{{asset('storage/uploads/'.$filename.'')}}">{{$filename}}</a> <i class="fas fa-trash" onclick="delfile('{{$filename}}','{{URL('/delfile?fl=')}}{{$filename}}');"></i><br>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (strtoupper(Auth::user()->email) == "WHSE.PICKER1@BRUSSELS.MSF.ORG" || strtoupper(Auth::user()->email) == "WHSE.PICKER2@BRUSSELS.MSF.ORG")
                @if (!empty($filenames))
                    <h3>Files to pick</h3>
                    @foreach ($filenames as $filename)
                        @if (explode("_", $filename)[0] == strtoupper($email))
                            {{-- @if (!strpos($filename, '_picked')) --}}
                                <a href="{{asset('storage/uploads/'.$filename.'')}}">{{$filename}}</a> 
                                <i class="fas fa-arrow-right pickButt" onclick="pickfile('{{$filename}}','{{URL('/pickfile?fl=')}}{{$filename}}');"></i>
                            {{-- @endif --}}
                            
                            <br>
                        @endif
                    @endforeach
                @endif
            @endif
        </div>
    </div>
@endsection