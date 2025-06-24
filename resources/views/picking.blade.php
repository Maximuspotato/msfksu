@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 id="phead">Picking</h1>
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
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 3; $i < 6; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 6; $i < 9; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 9; $i < 12; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 12; $i < 15; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 15; $i < 16; $i++)
                                <div class="col-xs-4">
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form id="formPick" action="{{URL('/updatePick')}}" method="post">
                            @csrf
                            <div class="row">
                                    <div class="col-xs-6">
                                        <label for="from"><b>From</b></label>
                                        <input type="number" name="from" id="from" value="{{$rows[$rowCount][16]}}">
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="to"><b>To</b></label>
                                        <input type="number" name="to" id="to" value="{{$rows[$rowCount][17]}}">
                                    </div>
                                <br><br>
                                    <div class="col-xs-6">
                                        <label for="plt"><b>NoPallet</b></label>
                                        <input type="number" name="plt" id="plt" value="{{$rows[$rowCount][18]}}">
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="lyr"><b>{{$rows[$header][19]}}</b></label>
                                        <input type="text" name="lyr" id="lyr" value="{{$rows[$rowCount][19]}}">
                                    </div>
                                <br><br>
                                    <div class="col-xs-6">
                                        <label for="dims"><b>{{$rows[$header][20]}}</b></label>
                                        <input type="text" name="dims" id="dims" value="{{$rows[$rowCount][20]}}">
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="rmk"><b>Remarks</b></label>
                                        @if (!isset($rows[$rowCount][21]))
                                            <input type="text" name="rmk" id="rmk" value="">
                                        @else
                                           <input type="text" name="rmk" id="rmk" value="{{$rows[$rowCount][21]}}"> 
                                        @endif
                                    </div>

                                    <input id="rc" type="hidden" name="rowCount" value="{{$rowCount}}">
                                    <input id="count" type="hidden" name="count" value="{{$count}}">
                                    <input type="hidden" name="filepath" value="{{$filepath}}">
                                    <input type="hidden" id="pg" name="pg" value="">
                            </div>
                        </form>
                        
                    </div>
                    <div class="modal-footer">
                        {{-- @if ($rowCount > 1) --}}
                            <button type="button" id="buttBack" class="btn btn-primary">Back</button>
                        {{-- @endif --}}
                        {{-- @if ($rowCount <= count($rows)-2) --}}
                            <button type="button" id="buttNext" class="btn btn-primary">Save changes</button>
                        {{-- @endif --}}
                        {{-- @if ($rowCount == count($rows)-1) --}}
                            <button type="button" id="buttConfirm" class="btn btn-primary">Confirm</button>
                        {{-- @endif --}}
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <br><br>
                      <div class="progress">
                        @php
                            $perc = ($rowCount/(count($rows)-1))*100;
                        @endphp
                        {{$rowCount}}/{{count($rows)-1}}
                        <div class="progress-bar" role="progressbar" style="width: {{$perc}}%" aria-valuenow="{{$perc}}" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
@endsection