@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 id="phead">Packing</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="modal" tabindex="-1" role="dialog" style="display: block; position:relative;">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                        <h1>{{$rows[$rowCount]['PCL_PCT_NO']}}</h1>
                    </div>
                    <div class="modal-body">
                        @php
                            $count = count($rows);
                        @endphp
                        <div class="row">
                            <div class="col-xs-5">
                                <p><b>Item</b>: {{$rows[$rowCount]['PCL_ART_CODE']}}</p>
                            </div>
                            <div class="col-xs-7">
                                <p><b>Description</b>: {{$rows[$rowCount]['PCL_DES1']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <p><b>Quantity</b>: {{$rows[$rowCount]['PCL_QTE_LIV']}}</p>
                            </div>
                            <div class="col-xs-4">
                                <p><b>Batch</b>: {{$rows[$rowCount]['PCL_NO_SERIE_LOT']}}</p>
                            </div>
                            <div class="col-xs-4">
                                <p><b>Expiry</b>: {{$rows[$rowCount]['PCL_DT_PEREMPTION']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <p><b>Boxes</b>: {{$rows[$rowCount]['PCC_NO_GROUPAGE']}} - {{$rows[$rowCount]['PCC_NO_COLIS_FIN']}}</p>
                            </div>
                            <div class="col-xs-8">
                                <form id="formPack" action="{{URL('/updatePack')}}" method="post">
                                    @csrf
                                    <label for="rmk"><b>Remarks</b></label>
                                    @if (!isset($rmks[0]['APL_RMK']))
                                        <input type="text" name="rmk" id="rmk" value="">
                                    @else
                                        <input type="text" name="rmk" id="rmk" value="{{$rmks[0]['APL_RMK']}}"> 
                                    @endif
                                    <input id="rcp" type="hidden" name="rowCount" value="{{$rowCount}}">
                                    <input id="pkno" type="hidden" name="pkno" value="{{$rows[$rowCount]['PCL_PCT_NO']}}">
                                    <input id="count" type="hidden" name="count" value="{{$count}}">
                                    <input type="hidden" id="pg" name="pg" value="">
                                    <input type="hidden" id="jmp" name="jmp" value="jmp">
                                </form>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        {{-- @if ($rowCount > 1) --}}
                            <button type="button" id="buttBackPack" class="btn btn-primary">Back</button>
                        {{-- @endif --}}
                        {{-- @if ($rowCount <= count($rows)-2) --}}
                            <button type="button" id="buttNextPack" class="btn btn-primary">Save changes</button>
                        {{-- @endif --}}
                        {{-- @if ($rowCount == count($rows)-1) --}}
                            <button type="button" id="buttConfirmPack" class="btn btn-primary">Confirm</button>
                        {{-- @endif --}}
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <br><br>
                      <div class="progress">
                        @php
                            $perc = (($rowCount+1)/(count($rows)))*100;
                        @endphp
                        {{($rowCount+1)}}/{{count($rows)}}
                        <div class="progress-bar" role="progressbar" style="width: {{$perc}}%" aria-valuenow="{{$perc}}" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <label for="jpt"><b>Jump to</b></label>
                        <input style="width: 10%" type="number" name="jpt" id="jpt" value="">
                        <button id="goButtPack">go</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
@endsection