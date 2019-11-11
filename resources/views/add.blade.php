@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if ($det == 'add')
                            <h1>Add item</h1>
                        @else
                            <h1>Edit item</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="container">
                <div class="row">
                    @if ($det == 'add')
                    <form action="{{URL('/import')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        Import article excel file
                        <input type="file" name="article" id="" required>
                        <button type="submit">Import</button>
                    </form>
                    <br>
                    <form action="{{URL('/importDonations')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        Import donations excel file
                        <input type="file" name="donation" id="" required>
                        <button type="submit">Import</button>
                    </form>
                    
                    <form id="upload_article" action="{{route('article.store')}}" method="POST">
                        @csrf
                        <!-- Full Description & Specification -->
                        <div class="col-sm-12">
                            <div class="tabbable">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs product-details-nav">
                                    <li class="active"><a href="#tab1" data-toggle="tab">Specification</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Description</a></li>
                                    <li><a href="#tab3" data-toggle="tab">Details</a></li>
                                </ul>
                                <!-- Tab Content (Full Description) -->
                                <div class="tab-content product-detail-info">
                                    <div class="tab-pane active" id="tab1">
                                        <table>
                                            <tr>
                                                <td>Article code *</td>
                                                <td><input id="article_code" type="text" class="form-control" name="article_code" required placeholder="eg PSAFHARNFA-"></td>
                                            </tr>
                                            <tr>
                                                <td>Category *</td>
                                                <td>
                                                    <select id="category" name="category" class="form-control" required>
                                                        <option value="">Choose category</option>
                                                        <option value="Log">Log</option>
                                                        <option value="Med">Med</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Group *</td>
                                                <td>
                                                    <select id="group" name="group" class="form-control" required>
                                                        <option value="">Choose group</option>
                                                        <option value="A">Administration / Office</option>
                                                        <option value="C">Camps & Construction</option>
                                                        <option value="D">Drugs</option>
                                                        <option value="E">Medical equipment</option>
                                                        <option value="I">Inventory lists / Checklists</option>
                                                        <option value="K">Kits</option>
                                                        <option value="L">Library</option>
                                                        <option value="N">Nutrition</option>
                                                        <option value="P">Program Support</option>
                                                        <option value="S">Renewable medical suppplies</option>
                                                        <option value="T">Transport</option>
                                                        <option value="X">Services</option>
                                                        <option value="Y">Mechanical spare parts</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Family *</td>
                                                <td>
                                                    <select id="family" name="family" class="form-control" required>
                                                        <option value="">Choose Family</option>
                                                    </select>
                                                    <input type="text" id="fam_desc" name="fam_desc" class="form-control hidden" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Price *</td>
                                                <td><input id="price" type="number" class="form-control" name="price" required placeholder="KSH"></td>
                                            </tr>
                                            <tr>
                                                <td>Price valid until *</td>
                                                <td><input type="text" class="form-control" name="valid" required id='datetimepicker4' placeholder=""></td>
                                            </tr>
                                            <tr>
                                                <td>Unit of distribution</td>
                                                <td><input type="text" class="form-control" name="unit" placeholder="..."></td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td><input type="number" class="form-control" name="weight" placeholder="kgs"></td>
                                            </tr>
                                            <tr>
                                                <td>Volume</td>
                                                <td><input type="number" class="form-control" name="volume" placeholder="dm3"></td>
                                            </tr>
                                            <tr>
                                                <td>Stock *</td>
                                                <td>
                                                    <select name="stock" id="stock" class="form-control" required>
                                                        <option value="">Choose stock</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td>Lead time *</td>
                                                <td><input id="lead_time" type="number" class="form-control" name="lead_time" required placeholder="in weeks"></td>
                                            </tr>
                                            {{-- <tr>
                                                <td>Donatable</td>
                                                <td>
                                                    <select name="donate" id="donate" class="form-control" required>
                                                        <option value="">Choose</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </td>
                                            </tr> --}}
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <h5>Description</h5>
                                        <p>
                                            <input id="desc_eng" type="text" name="desc_eng" class="form-control" placeholder="Description in English *" required>
                                        </p>
                                        <p>
                                            <input type="text" name="desc_fra" class="form-control" placeholder="Description in France">
                                        </p>
                                        <p>
                                            <input type="text" name="desc_spa" class="form-control" placeholder="Description in Spanish">
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="tab3">
                                        <h4>Product Details</h4>
                                        <p>
                                            <td><textarea id="article-ckeditor" name="details" rows="10" maxlength="1000" style="width: 100%;"></textarea></td>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Full Description & Specification -->
                        <br>
                    </form>
                    <div class="form-group">
                        <button id="upload_butt" class="btn-success btn-lg pull-right" onclick="event.preventDefault(); document.getElementById('upload_article').submit();" style="display:none">Finish uploading</button>
                        <button id="photo_butt" class="btn-primary btn-lg pull-left" onclick='event.preventDefault(); document.getElementById("upload_article").setAttribute("action", "{{URL("/upload-images")}}"); document.getElementById("upload_article").submit();' style="display:none">Add photos</button>
                        <div class="clearfix"></div>
                    </div>
                    @else
                    <form id="upload_article" action="{{URL('/article')}}/{{$article->article_code}}" method="POST">
                        @csrf
                        <input id="meth" name="_method" type="hidden" value="PUT">
                        <!-- Full Description & Specification -->
                        <div class="col-sm-12">
                            <div class="tabbable">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs product-details-nav">
                                    <li class="active"><a href="#tab1" data-toggle="tab">Specification</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Description</a></li>
                                    <li><a href="#tab3" data-toggle="tab">Details</a></li>
                                </ul>
                                <!-- Tab Content (Full Description) -->
                                <div class="tab-content product-detail-info">
                                    <div class="tab-pane active" id="tab1">
                                        <table>
                                            <tr>
                                                <td>Article code *</td>
                                                <td><input id="article_code" type="text" class="form-control" name="article_code" required placeholder="eg PSAFHARNFA-" value="{{$article->article_code}}"></td>
                                            </tr>
                                            <tr>
                                                <td>Category *</td>
                                                <td>
                                                    <select id="category" name="category" class="form-control" required>
                                                        <option value="{{$article->category}}">{{$article->category}}</option>
                                                        <option value="Log">Log</option>
                                                        <option value="Med">Med</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Group *</td>
                                                <td>
                                                    <select id="group" name="group" class="form-control" required>
                                                        <option value="">Choose group</option>
                                                        <option value="A">Administration / Office</option>
                                                        <option value="C">Camps & Construction</option>
                                                        <option value="D">Drugs</option>
                                                        <option value="E">Medical equipment</option>
                                                        <option value="I">Inventory lists / Checklists</option>
                                                        <option value="K">Kits</option>
                                                        <option value="L">Library</option>
                                                        <option value="N">Nutrition</option>
                                                        <option value="P">Program Support</option>
                                                        <option value="S">Renewable medical suppplies</option>
                                                        <option value="T">Transport</option>
                                                        <option value="X">Services</option>
                                                        <option value="Y">Mechanical spare parts</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Family *</td>
                                                <td>
                                                    <select id="family" name="family" class="form-control" required>
                                                        <option value="">Choose Family</option>
                                                    </select>
                                                    <input type="text" id="fam_desc" name="fam_desc" class="form-control hidden" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Price *</td>
                                                <td><input id="price" type="number" class="form-control" name="price" required placeholder="KSH" value="{{$article->price}}"></td>
                                            </tr>
                                            <tr>
                                                <td>Price valid until *</td>
                                                <td><input type="text" class="form-control" name="valid" required id='datetimepicker4' placeholder="" value="{{$article->valid}}"></td>
                                            </tr>
                                            <tr>
                                                <td>Unit of distribution</td>
                                                <td><input type="text" class="form-control" name="unit" placeholder="..." value="{{$article->unit}}"></td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td><input type="number" class="form-control" name="weight" placeholder="kgs" value="{{$article->weight}}"></td>
                                            </tr>
                                            <tr>
                                                <td>Volume</td>
                                                <td><input type="number" class="form-control" name="volume" placeholder="dm3" value="{{$article->volume}}"></td>
                                            </tr>
                                            <tr>
                                                <td>Stock *</td>
                                                <td>
                                                    <select name="stock" id="stock" class="form-control" required>
                                                        <option value="{{$article->stock}}">{{$article->stock}}</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td>Lead time *</td>
                                                <td><input id="lead_time" type="number" class="form-control" name="lead_time" required placeholder="in weeks" value="{{$article->lead_time}}"></td>
                                            </tr>
                                            {{-- <tr>
                                                <td>Donatable</td>
                                                <td>
                                                    <select name="donate" id="donate" class="form-control" required>
                                                        <option value="{{$article->donate}}">{{$article->donate}}</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </td>
                                            </tr> --}}
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <h5>Description</h5>
                                        <p>
                                            <input id="desc_eng" type="text" name="desc_eng" class="form-control" placeholder="Description in English *"  value="{{$article->desc_eng}}" required>
                                        </p>
                                        <p>
                                            <input type="text" name="desc_fra" class="form-control" placeholder="Description in France" value="{{$article->desc_fra}}">
                                        </p>
                                        <p>
                                            <input type="text" name="desc_spa" class="form-control" placeholder="Description in Spanish" value="{{$article->desc_spa}}">
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="tab3">
                                        <h4>Product Details</h4>
                                        <p>
                                            <td><textarea id="article-ckeditor" name="details" rows="10" maxlength="1000" style="width: 100%;">{{$article->details}}</textarea></td>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Full Description & Specification -->
                        <br>
                    </form>
                    <div class="form-group">
                        <button id="upload_butt" class="btn-success btn-lg pull-right" onclick="event.preventDefault(); document.getElementById('upload_article').submit();" style="display:none">Finish uploading</button>
                        <button id="photo_butt" class="btn-primary btn-lg pull-left" onclick='event.preventDefault(); document.getElementById("upload_article").setAttribute("action", "{{URL("/upload-images")}}?det=edit"); document.getElementById("meth").setAttribute("name", ""); document.getElementById("upload_article").submit();' style="display:none">Add photos</button>
                        <div class="clearfix"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
@endsection