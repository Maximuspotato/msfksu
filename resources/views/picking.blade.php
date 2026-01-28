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
                        <div class="row text-center">
                            <div class="col-xs-12">
                                <h1>{{$rows[$rowCount][1s]}}</h1>
                                <h2>{{$pickno}}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <p><b>{{$rows[$header][2]}}</b>:{{$rows[$rowCount][2]}}</p>
                            </div>
                            <div class="col-xs-12">
                                <p>{{$rows[$rowCount][3]}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <p><b>{{$rows[$header][4]}}</b>:{{$rows[$rowCount][4]}}</p>
                            </div>
                            <div class="col-xs-6">
                                <p><b>{{$rows[$header][5]}}</b>:{{ \Carbon\Carbon::createFromDate(1899, 12, 30)->addDays($rows[$rowCount][5])->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><b>{{$rows[$header][6]}}</b>:{{$rows[$rowCount][6]}}</p>
                            </div>
                            <div class="col-xs-3">
                                <p><b>{{$rows[$header][7]}}</b>:{{$rows[$rowCount][7]}}</p>
                            </div>
                            <div class="col-xs-3">
                                <p><b>{{$rows[$header][8]}}</b>:{{$rows[$rowCount][8]}}</p>
                            </div>
                            <div class="col-xs-3">
                                <p><b>{{$rows[$header][9]}}</b>:{{$rows[$rowCount][9]}}</p>
                            </div>
                        </div>
                        {{-- <div class="row">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="col-xs-6">
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 3; $i < 6; $i++)
                                <div class="col-xs-6">
                                    <p><b>{{$rows[$header][$i]}}</b>:{{$rows[$rowCount][$i]}}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="row">
                            @for ($i = 6; $i < 9; $i++)
                                <div class="col-xs-6">
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
                        </div> --}}
                        {{-- <div class="row">
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
                        </div> --}}
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form id="formPick" action="{{URL('/updatePick')}}" method="post">
                            @csrf
                            <div class="row">
                                    <div class="col-xs-4">
                                        <label for="from"><b>From</b></label>
                                        <input style="width: -webkit-fill-available;" type="number" name="from" id="from" value="{{$rows[$rowCount][12]}}">
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="to"><b>To</b></label>
                                        <input style="width: -webkit-fill-available;" type="number" name="to" id="to" value="{{$rows[$rowCount][13]}}">
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="plt"><b>NoPallet</b></label>
                                        <input style="width: -webkit-fill-available;" type="number" name="plt" id="plt" value="{{$rows[$rowCount][14]}}">
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="to"><b>Remark</b></label>
                                        @if (!isset($rows[$rowCount][15]))
                                            <input style="width: -webkit-fill-available;" type="text" name="rmk" id="rmk" value="">
                                        @else
                                           <input style="width: -webkit-fill-available;" type="text" name="rmk" id="rmk" value="{{$rows[$rowCount][15]}}"> 
                                        @endif
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="plt"><b>Weight</b></label>
                                        <input style="width: -webkit-fill-available;" type="number" name="wgt" id="wgt" value="{{$rows[$rowCount][10]}}">
                                    </div>
                                    {{-- <div class="col-xs-6">
                                        <label for="lyr"><b>{{$rows[$header][19]}}</b></label>
                                        <input style="width: -webkit-fill-available;" type="text" name="lyr" id="lyr" value="{{$rows[$rowCount][19]}}">
                                    </div>
                                <br><br>
                                    <div class="col-xs-6">
                                        <label for="dims"><b>{{$rows[$header][20]}}</b></label>
                                        <input style="width: -webkit-fill-available;" type="text" name="dims" id="dims" value="{{$rows[$rowCount][20]}}">
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="rmk"><b>Remarks</b></label>
                                        @if (!isset($rows[$rowCount][21]))
                                            <input style="width: -webkit-fill-available;" type="text" name="rmk" id="rmk" value="">
                                        @else
                                           <input style="width: -webkit-fill-available;" type="text" name="rmk" id="rmk" value="{{$rows[$rowCount][21]}}"> 
                                        @endif
                                    </div> --}}
                                    <hr style="border: none; height: 2px;background-color: #333; margin: 20px 0;">

                                    <input id="rc" type="hidden" name="rowCount" value="{{$rowCount}}">
                                    <input id="count" type="hidden" name="count" value="{{$count}}">
                                    <input type="hidden" name="filepath" value="{{$filepath}}">
                                    <input type="hidden" name="pickno" value="{{$pickno}}">
                                    <input type="hidden" id="pg" name="pg" value="">
                                    <input type="hidden" id="jmp" name="jmp" value="jmp">
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
                      <label for="jpt"><b>Jump to</b></label>
                        <input style="width: 10%" type="number" name="jpt" id="jpt" value="">
                        <button id="goButt">go</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
@endsection