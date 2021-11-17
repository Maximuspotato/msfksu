@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>RFQ item not in catalogue</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h5>This form is to request a quotation for an item that is not displayed in our catalogue.</h5>
                        <div class="basic-login">
                            <form method="POST" action="{{URL('/send-item-request')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname *') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" autocomplete="surname" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Last name *') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lname') }}" autocomplete="lname" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="article_code" class="col-md-4 col-form-label text-md-right">{{ __('Unidata code') }}<br><span>If existing</span></label>

                                            <div class="col-md-6">
                                                <input id="article_code" type="text" class="form-control" name="article_code" value="{{ old('article_code') }}" autocomplete="article_code" autofocus placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description *') }}<br><span>Use Unidata description if existing</span></label>
                                    
                                            <div class="col-md-6">
                                                <textarea id="description" class="form-control" name="description" value="{{ old('description') }}" autocomplete="description" autofocus required rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantity *') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="quantity" type="number" class="form-control" name="quantity" value="{{ old('quantity') }}" autocomplete="quantity" autofocus required placeholder="as per description">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="budget" class="col-md-4 col-form-label text-md-right">{{ __('Indicative budget (USD)*') }}<br><span>Exclusive of additional cost [e.g. transportation]</span></label>
                                    
                                            <div class="col-md-6">
                                                <input id="budget" type="number" step="0.001" min="0" class="form-control" name="budget" value="0.001" autocomplete="budget" autofocus requiredquan placeholder="in USD">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="brand" class="col-md-4 col-form-label text-md-right">{{ __('Brand') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="brand" type="text" class="form-control" name="brand" value="{{ old('brand') }}" autocomplete="brand" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="specifications" class="col-md-4 col-form-label text-md-right">{{ __('Specifications') }}</label>
                                    
                                            <div class="col-md-6">
                                                <textarea id="specifications" class="form-control" name="specifications" value="{{ old('specifications') }}" autocomplete="specifications" autofocus placeholder="e.g. size, color, dimension etc." rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="attachment" class="col-md-4 col-form-label text-md-right">{{ __('Attachment') }}<br><span>Maximum file size is 2MB</span><br><span style="font-size:10px">Select all files during uploading when you want to add multiple</span></label>
                                    
                                            <div class="col-md-6">
                                                <input id="attachment" type="file" class="form-control" name="attachment[]" value="{{ old('attachment') }}" autocomplete="attachment" autofocus multiple="" onChange="makeFileList();">
                                                <ul id="filelist"><li>No file selected</li></ul>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="website" class="col-md-4 col-form-label text-md-right">{{ __('Website link') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="website" type="text" class="form-control" name="website" value="{{ old('website') }}" autocomplete="website" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="ddate" class="col-md-4 col-form-label text-md-right">{{ __('Expected delivery date') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="ddate" type="date" class="form-control" name="ddate" value="{{ old('ddate') }}" autocomplete="ddate" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="transport" class="col-md-4 col-form-label text-md-right">{{ __('Transport mode') }}<br><span>Preffered transport mode from KSU to field</span></label>
                                    
                                            <div class="col-md-6">
                                                <input id="transport" type="text" class="form-control" name="transport" value="{{ old('transport') }}" autocomplete="transport" autofocus>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary pull-right">
                                            {{ __('Request') }}
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
