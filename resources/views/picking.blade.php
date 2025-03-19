@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Picking</h1>
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
                        @php
                            $count = count($rows);
                        @endphp
                        <div class="row">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$rowCount][$i]}}</b>:{{$rows[$rowCount+1][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 3; $i < 6; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$rowCount][$i]}}</b>:{{$rows[$rowCount+1][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 6; $i < 9; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$rowCount][$i]}}</b>:{{$rows[$rowCount+1][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 9; $i < 12; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$rowCount][$i]}}</b>:{{$rows[$rowCount+1][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 12; $i < 15; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$rowCount][$i]}}</b>:{{$rows[$rowCount+1][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 15; $i < 16; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$rowCount][$i]}}</b>:{{$rows[$rowCount+1][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="row">
                                @for ($i = 16; $i < 18; $i++)
                                    <div class="col-xs-6">
                                        <label for=""><b>{{$rows[$rowCount][$i]}}</b></label>
                                    </div>
                                @endfor
                            </div>
                        </form>
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary">Save changes</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
@endsection