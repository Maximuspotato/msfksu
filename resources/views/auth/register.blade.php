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
                                            <label for="mission" class="col-md-4 col-form-label text-md-right">{{ __('Mission') }}</label>
                                    
                                            <div class="col-md-6">
                                                {{-- <select id="mission" name="mission" class="form-control @error('name') is-invalid @enderror" value="{{ old('mission') }}" autocomplete="name" autofocus>
                                                    <option value="ALIMA">ALIMA</option>
                                                    <option value="MSF SPAIN ANGOLA">MSF SPAIN ANGOLA</option>
                                                    <option value="OCB RDC BON DE COMMANDE">OCB RDC BON DE COMMANDE</option>
                                                    <option value="MSF-BE-CASTOR MEDICAL">MSF-BE-CASTOR MEDICAL</option>
                                                    <option value="OCB GUINEE">OCB GUINEE</option>
                                                    <option value="MSF BELGIUM - EMBU PROJECT">MSF BELGIUM - EMBU PROJECT</option>
                                                    <option value="OCBKE- EPREP STOCK">OCBKE- EPREP STOCK</option>
                                                    <option value="OCBKE- EPREP STOCK">OCBKE- EPREP STOCK</option>
                                                    <option value="MSF BELGIUM (OCB)-ISLAMABAD">MSF BELGIUM (OCB)-ISLAMABAD</option>
                                                    <option value="MSF Supply">MSF Supply</option>
                                                    <option value="MSF OCB SIERRA LEONE MISSION">MSF OCB SIERRA LEONE MISSION</option>
                                                    <option value="MSF Supply">MSF Supply</option>
                                                    <option value="MSF BELGIUM KIAMBU PROJECT">MSF BELGIUM KIAMBU PROJECT</option>
                                                    <option value="MSFOCB - Belgium Burundi">MSFOCB - Belgium Burundi</option>
                                                    <option value="MSF SPAIN HQ">MSF SPAIN HQ</option>
                                                    <option value="MSFOCB-BELGIUM (CAR)">MSFOCB-BELGIUM (CAR)</option>
                                                    <option value="MSFOCBA-SWITSLAND (CAR)">MSFOCBA-SWITSLAND (CAR)</option>
                                                    <option value="MSFB CASTER LOGISTIQUE">MSFB CASTER LOGISTIQUE</option>
                                                    <option value="MSF- OCBA BUKAVU">MSF- OCBA BUKAVU</option>
                                                    <option value="OCB DRC (Goma)">OCB DRC (Goma)</option>
                                                    <option value="OCP DRC">OCP DRC</option>
                                                    <option value="OCA DRC">OCA DRC</option>
                                                    <option value="MSF OCP DRC LUBUMBASHI">MSF OCP DRC LUBUMBASHI</option>
                                                    <option value="OCBA DRC">OCBA DRC</option>
                                                    <option value="MSF FRANCE TCHAD-N'DJAMENA">MSF FRANCE TCHAD-N'DJAMENA</option>
                                                    <option value="OCB Egypt">OCB Egypt</option>
                                                    <option value="MSF- EPZ WAREHOUSE-KSU">MSF- EPZ WAREHOUSE-KSU</option>
                                                    <option value="MSF SPAIN ANGOLA">MSF SPAIN ANGOLA</option>
                                                    <option value="MSF- OCBA BUKAVU- RUSK PROJECT">MSF- OCBA BUKAVU- RUSK PROJECT</option>
                                                    <option value="COMMANDE MOSTIQUARES/MANONO">COMMANDE MOSTIQUARES/MANONO</option>
                                                    <option value="MSF SPAIN  BANGUI SUPPLY">MSF SPAIN  BANGUI SUPPLY</option>
                                                    <option value="MSF SPAIN BANGUI SUPPLY">MSF SPAIN BANGUI SUPPLY</option>
                                                    <option value="MSF SPAIN ETHIOPIA">MSF SPAIN ETHIOPIA</option>
                                                    <option value="MSF-SPAIN NAIROBI BRANCH">MSF-SPAIN NAIROBI BRANCH</option>
                                                    <option value="MSF SPAIN KINSHASA">MSF SPAIN KINSHASA</option>
                                                    <option value="OCBA Ethiopia">OCBA Ethiopia</option>
                                                    <option value="OCP Ethiopia">OCP Ethiopia</option>
                                                    <option value="KSU warehouse Nairobi">KSU warehouse Nairobi</option>
                                                    <option value="OCB Kenya">OCB Kenya</option>
                                                    <option value="OCB Kenya">OCB Kenya</option>
                                                    <option value="OCBA East Africa">OCBA East Africa</option>
                                                    <option value="OCP Kenya">OCP Kenya</option>
                                                    <option value="OCP Kenya">OCP Kenya</option>
                                                    <option value="KSU - COORDINATION">KSU - COORDINATION</option>
                                                    <option value="OCPKE EPREP STOCK">OCPKE EPREP STOCK</option>
                                                    <option value="OCG KENYA-MANDERA">OCG KENYA-MANDERA</option>
                                                    <option value="OCB Kenya Guesthouse">OCB Kenya Guesthouse</option>
                                                    <option value="OCG Kenya Coordination">OCG Kenya Coordination</option>
                                                    <option value="OCG Kenya Coordination">OCG Kenya Coordination</option>
                                                    <option value="OCP Kenya Homabay/Ndhiwa">OCP Kenya Homabay/Ndhiwa</option>
                                                    <option value="OCP Kenya Homabay/Ndhiwa">OCP Kenya Homabay/Ndhiwa</option>
                                                    <option value="OCB KE Kibera South Health Clinic">OCB KE Kibera South Health Clinic</option>
                                                    <option value="OCG Kenya Dadaab">OCG Kenya Dadaab</option>
                                                    <option value="OCG Kenya Dadaab">OCG Kenya Dadaab</option>
                                                    <option value="OCP Kenya Mathare">OCP Kenya Mathare</option>
                                                    <option value="OCP Kenya Mathare">OCP Kenya Mathare</option>
                                                    <option value="OCB Kenya Silanga clinic">OCB Kenya Silanga clinic</option>
                                                    <option value="OCG Kenya Likoni">OCG Kenya Likoni</option>
                                                    <option value="OCG Kenya Likoni">OCG Kenya Likoni</option>
                                                    <option value="EPICENTRE RESEARCH BASE-MBARARA">EPICENTRE RESEARCH BASE-MBARARA</option>
                                                    <option value="MSFCH Emergency">MSFCH Emergency</option>
                                                    <option value="MSFCH Emergency">MSFCH Emergency</option>
                                                    <option value="OCG KENYA MOMBASA">OCG KENYA MOMBASA</option>
                                                    <option value="MSF-KSU COORDINATION">MSF-KSU COORDINATION</option>
                                                    <option value="OCB Malawi">OCB Malawi</option>
                                                    <option value="MSF HOLLAND , JUBA SOUTH SUDAN">MSF HOLLAND , JUBA SOUTH SUDAN</option>
                                                    <option value="MSFF MOZAMBIQUE">MSFF MOZAMBIQUE</option>
                                                    <option value="MSF FRANCE RCA">MSF FRANCE RCA</option>
                                                    <option value="MSF FRANCE RCA">OCBA North Sudan</option>
                                                    <option value="OCB  North Sudan">OCB  North Sudan</option>
                                                    <option value="MSF OCBA SIERRA LEON">MSF OCBA SIERRA LEON</option>
                                                    <option value="MSF OCP SOMALILAND">MSF OCP SOMALILAND</option>
                                                    <option value="MSFOCB - Belgium South Sudan">MSFOCB - Belgium South Sudan</option>
                                                    <option value="MSFOCB - Belgium South Sudan">MSFOCB - Belgium South Sudan</option>
                                                    <option value="MSF  SPAIN (OCBA) South Sudan">MSF  SPAIN (OCBA) South Sudan</option>
                                                    <option value="MSF FRANCE (OCP) South Sudan">MSF FRANCE (OCP) South Sudan</option>
                                                    <option value="EMERGENCY MAUC/ MAYOM">EMERGENCY MAUC/ MAYOM</option>
                                                    <option value="OCG South Sudan">OCG South Sudan</option>
                                                    <option value="OCG TANZANIA">OCG TANZANIA</option>
                                                    <option value="MEDECINES SANS FRONTIERES">MEDECINES SANS FRONTIERES</option>
                                                    <option value="MSF DUBAI-UAE">MSF DUBAI-UAE</option>
                                                    <option value="MSFOCG-Switzerland UGANDA">MSFOCG-Switzerland UGANDA</option>
                                                    <option value="MSFOCG-Switzerland UGANDA">MSFOCG-Switzerland UGANDA</option>
                                                    <option value="OCP UGANDA">OCP UGANDA</option>
                                                </select> --}}
                                                <input id="mission" type="text" class="form-control @error('mission') is-invalid @enderror" name="mission" value="{{ old('mission') }}" autocomplete="mission">
                                                @error('mission')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="oc" class="col-md-4 col-form-label text-md-right">{{ __('OC *') }}</label>
                                            
                                            <div class="col-md-6">
                                                <select id="oc" name="oc" class="form-control @error('oc') is-invalid @enderror" value="{{ old('oc') }}" autocomplete="oc" autofocus required>
                                                    <option value="OCB">OCB</option>
                                                    <option value="OCBA">OCBA</option>
                                                    <option value="OCA">OCA</option>
                                                    <option value="OCG">OCG</option>
                                                    <option value="OCP">OCP</option>
                                                    <option value="INTERNATIONAL">INTERNATIONAL</option>
                                                </select>
                                                @error('mission')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="project" class="col-md-4 col-form-label text-md-right">{{ __('Project') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="project" type="text" class="form-control @error('project') is-invalid @enderror" name="project" value="{{ old('project') }}" required autocomplete="project">
                                    
                                                @error('project')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position *') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="position" type="position" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position">
                                    
                                                @error('position')
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
                                    </div>
                                    <div class="col-sm-6">
                                        If you work in supply, place orders or other requests, please tick the box.
                                        {{-- <label for="category">Works in Supply</label> --}}
                                        <input type="checkbox" name="category" id="category"><br>
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
                                        </div>
                                    
                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="should be a minimum of 6 characters">
                                    
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
@endsection
