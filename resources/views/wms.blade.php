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
            <h2>Welcome {{$email}} <i class="fas fa-eye" onclick="wmsrep('{{URL('/wmsrep')}}');"></i></h2>
            
            @if (strtoupper(Auth::user()->email) == "WHSE.SUPERVISOR@BRUSSELS.MSF.ORG"
            ||strtoupper(Auth::user()->email) == "PATRICK.KAMAU@BRUSSELS.MSF.ORG"
            ||strtoupper(Auth::user()->email) == "JACOB.NJAGI@BRUSSELS.MSF.ORG")
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Upload file for picking</h3>
                        <form action="{{URL('/uploadPick')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" required><br>
                            <select name="picker" id="picker" required>
                                <option value="ISAAC OCHIENG">ISAAC OCHIENG</option>
                                <option value="TERESIAH MUCHIRI">TERESIAH MUCHIRI</option>
                                <option value="WILSON NJERU">WILSON NJERU</option>
                                <option value="ZAKAYO KARANU">ZAKAYO KARANU</option>
                                <option value="WHSE PICKER1">WHSE PICKER1</option>
                                <option value="WHSE PICKER2">WHSE PICKER2</option>
                            </select><br><br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h3>Overview files for picking</h3>
                        @foreach ($filenames as $filename)
                            <a href="{{asset('storage/uploads/'.$filename.'')}}">{{$filename}}</a>
                            {{-- @if (strpos($filename, '_picked')) --}}
                                @php
                                    $exp = explode('_',$filename);
                                    $picking = $exp[1];
                                @endphp
                                {{-- <i class="fas fa-download" onclick="updpick('{{$picking}}','{{URL('/updpick?pickno=')}}{{$picking}}&fl={{$filename}}')"></i> --}}
                            {{-- @else --}}
                                <i class="fas fa-trash" onclick="delfile('{{$filename}}','{{URL('/delfile?fl=')}}{{$filename}}');"></i>
                            {{-- @endif --}}
                            <br>
                        @endforeach
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h3><u>Overview files for packing</u></h3>
                        <form id="choosePacker" action="{{URL('/choosePacker')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <select name="choosePCT" id="choosePCT">
                                 @foreach ($query_results as $query_result)
                                    @php
                                        // Check if this PCT_NO exists in the queryPackers list
                                        $exists = collect($queryPackers)->contains('EAP_PKNO', $query_result['PCT_NO']);
                                    @endphp

                                    @if (!$exists)
                                        <option value="{{ $query_result['PCT_NO'] }}">{{ $query_result['PCT_NO'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <select name="packer" id="packer" required>
                                <option value="ISAAC OCHIENG">ISAAC OCHIENG</option>
                                <option value="TERESIAH MUCHIRI">TERESIAH MUCHIRI</option>
                                <option value="WILSON NJERU">WILSON NJERU</option>
                                <option value="ZAKAYO KARANU">ZAKAYO KARANU</option>
                                <option value="WHSE PICKER1">WHSE PICKER1</option>
                                <option value="WHSE PICKER2">WHSE PICKER2</option>
                            </select>
                        </form>
                        <i class="fas fa-file" onclick="confPack()"></i>
                        {{-- @foreach ($query_results as $query_result)
                            @if (count($queryPackers) != 0)
                                @foreach ($queryPackers as $queryPacker)
                                    @if ($query_result['PCT_NO'] != $queryPacker['EAP_PKNO'])
                                        <ul>
                                            <li style="display: flex;">{{$query_result['PCT_NO']}} 
                                                <form id="choosePacker" action="{{URL('/choosePacker')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <select name="packer" id="packer" required>
                                                        <option value="ISAAC OCHIENG">ISAAC OCHIENG</option>
                                                        <option value="TERESIAH MUCHIRI">TERESIAH MUCHIRI</option>
                                                        <option value="WILSON NJERU">WILSON NJERU</option>
                                                        <option value="ZAKAYO KARANU">ZAKAYO KARANU</option>
                                                        <option value="WHSE PICKER1">WHSE PICKER1</option>
                                                        <option value="WHSE PICKER2">WHSE PICKER2</option>
                                                    </select><br><br>
                                                    <input type="hidden" name="pk_no" value="{{$query_result['PCT_NO']}}">
                                                </form> 
                                                <i class="fas fa-file" onclick="confPack('{{$query_result['PCT_NO']}}')"></i>
                                            </li>
                                        </ul>
                                    @endif
                                @endforeach
                            @else
                                <ul>
                                        <li style="display: flex;">{{$query_result['PCT_NO']}} 
                                            <form id="choosePacker" action="{{URL('/choosePacker')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <select name="packer" id="packer" required>
                                                    <option value="ISAAC OCHIENG">ISAAC OCHIENG</option>
                                                    <option value="TERESIAH MUCHIRI">TERESIAH MUCHIRI</option>
                                                    <option value="WILSON NJERU">WILSON NJERU</option>
                                                    <option value="ZAKAYO KARANU">ZAKAYO KARANU</option>
                                                    <option value="WHSE PICKER1">WHSE PICKER1</option>
                                                    <option value="WHSE PICKER2">WHSE PICKER2</option>
                                                </select><br><br>
                                                <input type="hidden" name="pk_no" value="{{$query_result['PCT_NO']}}">
                                            </form> 
                                            <i class="fas fa-file" onclick="confPack('{{$query_result['PCT_NO']}}')"></i>
                                        </li>
                                    </ul>
                            @endif
                        @endforeach --}}
                    </div>
                    <div class="col-sm-6">
                        <h3><u>Overview files being packed</u></h3>
                        @foreach ($queryPackers as $queryPacker)
                            <ul>
                                <li>{{$queryPacker['EAP_PKNO']}} ({{$queryPacker['EAP_PACKER']}})
                                    @if ($queryPacker['EAP_PACKED'] != NULL)
                                        {{-- (PACKED) <i class="fas fa-download" onclick="intPack('{{$queryPacker['EAP_PKNO']}}','{{URL('/intPack?pkno=')}}{{$queryPacker['EAP_PKNO']}}')"></i> --}}
                                        (PACKED)
                                    @endif
                                    @if ($queryPacker['EAP_INT'] != NULL)
                                        (INTEGRATED)
                                    @endif
                                    <i class="fas fa-trash" onclick="delPacker('{{$queryPacker['EAP_PKNO']}}','{{URL('/delPacker?pkno=')}}{{$queryPacker['EAP_PKNO']}}')"></i>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (strtoupper(Auth::user()->email) == "WHSE.PICKER1@BRUSSELS.MSF.ORG"
            || strtoupper(Auth::user()->email) == "WHSE.PICKER2@BRUSSELS.MSF.ORG"
            || strtoupper(Auth::user()->email) == "ISAAC.OCHIENG@BRUSSELS.MSF.ORG"
            || strtoupper(Auth::user()->email) == "WILSON.NJERU@BRUSSELS.MSF.ORG"
            || strtoupper(Auth::user()->email) == "ZAKAYO.KARANU@BRUSSELS.MSF.ORG"
            || strtoupper(Auth::user()->email) == "TERESIAH.MUCHIRI@BRUSSELS.MSF.ORG")
                <div class="row">
                    <div class="col-sm-6">
                        @if (!empty($filenames))
                            <h3>Files to pick</h3>
                            @foreach ($filenames as $filename)
                                @if (explode("_", $filename)[0] == strtoupper($email))
                                    @if (!strpos($filename, '_picked'))
                                        <a href="{{asset('storage/uploads/'.$filename.'')}}">{{$filename}}</a> 
                                        <i class="fas fa-arrow-right pickButt" onclick="pickfile('{{$filename}}','{{URL('/pickfile?fl=')}}{{$filename}}');"></i>
                                    @endif 
                                    <br>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="col-sm-6">
                        <h3>Files to pack</h3>
                        {{-- @isset($queryPackers) --}}
                            @foreach ($queryPackers as $queryPacker)
                                @if ($queryPacker['EAP_PACKER'] == strtoupper($email))
                                    @if ($queryPacker['EAP_PACKED'] == NULL)
                                        <ul>
                                            <li>{{$queryPacker['EAP_PKNO']}}
                                                <i class="fas fa-arrow-right" onclick="packing('{{$queryPacker['EAP_PKNO']}}','{{URL('/packing?pkno=')}}{{$queryPacker['EAP_PKNO']}}')"></i>
                                            </li>
                                        </ul>
                                    @endif
                                @endif
                            @endforeach
                        {{-- @endisset --}}
                    </div>
                </div>
                

            @endif
        </div>
    </div>
@endsection