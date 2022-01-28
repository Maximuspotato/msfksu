@extends('layouts.app')

@section('content')
    @php
        include(app_path() . '\outils\functions.php');
        $c = db_connect();
    @endphp
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
        
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="basic-login">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('First Name *') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="fname">
                                                @error('fname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="lname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name *') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname">
                                                @error('lname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail *') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="oc" class="col-md-4 col-form-label text-md-right">{{ __('OC *') }}</label>
                                            
                                            <div class="col-md-6">
                                                <select id="oc" name="oc" class="form-control @error('oc') is-invalid @enderror" value="{{ old('oc') }}" autocomplete="oc" autofocus required onchange="sectFunc()">
                                                    <option value="OCB">OCB</option>
                                                    <option value="OCBA">OCBA</option>
                                                    <option value="OCA">OCA</option>
                                                    <option value="OCG">OCG</option>
                                                    <option value="OCP">OCP</option>
                                                    <option value="INTERNATIONAL">INTERNATIONAL</option>
                                                </select>
                                                @error('oc')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="level" id="levelLabel" class="col-md-4 col-form-label text-md-right">{{ __('Level *') }}</label>
                                            
                                            <div class="col-md-6">
                                                <select id="level" name="level" class="form-control @error('level') is-invalid @enderror" value="{{ old('level') }}" autocomplete="level" autofocus required onchange="levelFunc()">
                                                    <option value="hq">HQ</option>
                                                    <option value="field">Field</option>
                                                </select>
                                                @error('level')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label id="countryLabel" for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country *') }}</label>
                                            
                                            <div class="col-md-6">
                                                <select id="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}" autocomplete="country" autofocus required>
                                                    @php
                                                        $query_country = " SELECT DISTINCT PAY_CODE, PAY_NOM 
                                                                                FROM XN_PAYS        
                                                                                ORDER BY PAY_CODE ASC
                                                                            ";
                                                        $stmt = oci_parse($c, $query_country);
                                                        ociexecute($stmt, OCI_DEFAULT);
                                                        $nrows = ocifetchstatement($stmt, $result_country,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
                                                        
                                                        foreach($result_country as $one_country){
                                                            echo '<option value='.$one_country['PAY_CODE'].'>'.$one_country['PAY_NOM'].'</option>';	
                                                        }
                                                    @endphp
                                                </select>
                                                @error('country')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        {{-- If you work in supply, place orders or other requests, please tick the box. --}}
                                        {{-- <label for="category">Works in Supply</label> --}}
                                        {{-- <input type="checkbox" name="category" id="category"><br>
                                        Through this you will be able to access some other features.                                       
                                        <div class="form-group row">
                                            <br>
                                            <label for="comments" class="col-md-4 col-form-label text-md-right">{{ __('Comments') }}</label>
                                            
                                            <div class="col-md-6">
                                                <textarea id="comments" class="form-control @error('comments') is-invalid @enderror" name="comments" value="{{ old('comments') }}" autocomplete="comments" rows="3"></textarea>
                                                @error('comments')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                    
                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="should be a minimum of 8 characters">
                                    
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary pull-right">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var country = document.getElementById('country');
            var countryLabel = document.getElementById('countryLabel');

            var level = document.getElementById('level');
            var levelLabel = document.getElementById('levelLabel');

            country.style.display = "none";
            countryLabel.style.display = "none";
            country.value = null;
            country.required = false;
            function sectFunc() {
                if (document.getElementById('oc').value == 'INTERNATIONAL') {
                    country.style.display = "none";
                    countryLabel.style.display = "none";
                    country.value = null;
                    country.required = false;

                    level.style.display = "none";
                    levelLabel.style.display = "none";
                    level.value = null;
                    level.required = false;
                }else{
                    level.style.display = "block";
                    levelLabel.style.display = "block";
                }
            }

            function levelFunc() {
                if (level.value == 'hq') {
                    country.style.display = "none";
                    countryLabel.style.display = "none";
                    country.value = null;
                    country.required = false;
                }else{
                    country.style.display = "block";
                    countryLabel.style.display = "block";
                    country.required = true;
                }
            }
        </script>
@endsection
