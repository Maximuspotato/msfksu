@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 id="phead">Integrate into Nodhos</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="modal" tabindex="-1" role="dialog" style="display: block; position:relative;">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                       Choose file to integrate {{$pctno}}
                    </div>
                    <div class="modal-body">
                        @foreach ($filenames as $filename)
                            <a href="{{asset('storage/uploads/'.$filename.'')}}">{{$filename}}</a> <i class="fas fa-download" onclick="intpkg('{{$filename}}','{{URL('/intpkg?fl=')}}{{$filename}}');"></i><br>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
@endsection