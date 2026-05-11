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
            
            @if (Auth::user()->roles == "MNG"
            ||Auth::user()->roles == "SPV")
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Upload file for picking</h3>
                        <form action="{{URL('/uploadPick')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" required><br>
                            <select name="picker" id="picker" required>
                                <option value="JULIAS ANDERA">JULIAS ANDERA</option>
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
                            @if (strpos($filename, '_picked'))
                                {{-- <i class="fas fa-download" onclick="updpick('{{$picking}}','{{URL('/updpick?pickno=')}}{{$picking}}&fl={{$filename}}')"></i> --}}
                            @else
                                <a href="{{asset('storage/uploads/'.$filename.'')}}">{{$filename}}</a>
                                 @php
                                    $exp = explode('_',$filename);
                                    $picking = $exp[1];
                                @endphp
                                <i class="fas fa-trash" onclick="delfile('{{$filename}}','{{URL('/delfile?fl=')}}{{$filename}}');"></i>
                                <br>
                            @endif
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
                                <option value="JULIAS ANDERA">JULIAS ANDERA</option>
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
                                                        <option value="JULIAS ANDERA">JULIAS ANDERA</option>
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
                                                    <option value="JULIAS ANDERA">JULIAS ANDERA</option>
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
                                
                                    @if ($queryPacker['EAP_PACKED'] == NULL)
                                        <li>{{$queryPacker['EAP_PKNO']}} ({{$queryPacker['EAP_PACKER']}})
                                            <i class="fas fa-trash" onclick="delPacker('{{$queryPacker['EAP_PKNO']}}','{{URL('/delPacker?pkno=')}}{{$queryPacker['EAP_PKNO']}}')"></i>
                                            </li>
                                    @endif
                                    {{-- @if ($queryPacker['EAP_INT'] != NULL)
                                        (INTEGRATED)
                                    @endif --}}
                                    
                            </ul>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (Auth::user()->roles == "PCK")
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
            @if (Auth::user()->roles == "MNG")
                <hr>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h3><u>User Management</u></h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>User Email</th>
                                    <th>Current Role</th>
                                    <th>Update Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($allUsers)
                                    @foreach ($allUsers as $user)
                                        <tr>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->roles }}</td>
                                            <td>
                                                <form action="{{ URL('/updateRole') }}" method="POST" id="form-role-{{ $user->id }}" style="display: flex; align-items: center; margin: 0;">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <!-- Update options to match your actual roles -->
                                                    <select name="new_role" required style="margin-right: 15px; padding: 5px;">
                                                        <option value="MNG" {{ $user->roles == 'MNG' ? 'selected' : '' }}>Manager (MNG)</option>
                                                        <option value="SPV" {{ $user->roles == 'SPV' ? 'selected' : '' }}>Supervisor (SPV)</option>
                                                        <option value="PCK" {{ $user->roles == 'PCK' ? 'selected' : '' }}>Picker (PCK)</option>
                                                    </select>
                                                    
                                                    <!-- Icon submits the specific form based on user ID -->
                                                    <i class="fas fa-save" title="Update Role" style="cursor: pointer; font-size: 1.2em;" onclick="document.getElementById('form-role-{{ $user->id }}').submit();"></i>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No users found. Ensure $allUsers is passed from the controller.</td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection