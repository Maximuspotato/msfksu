@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Requests</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="container">
                @if (count($items)>0)
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Action Buttons -->
                            {{-- <div class="pull-left">
                                <a href="{{URL('/new-request')}}" class="btn rfq-butt"><i class="glyphicon glyphicon-plus-sign"></i> REQUEST ITEM NOT IN CATALOGUE</a>
                            </div><br> --}}
                            <div class="pull-right">
                                @if (AUTH::guest())
                                    <a class="btn rfq-butt" href="{{URL('/login')}}" data-trigger="hover" title="Download internal request form"><i class="glyphicon glyphicon-download"></i> IR FORM</a>
                                    <a href="{{URL('/login')}}" class="btn rfq-butt" data-trigger="hover" title="Download Unifield importation file: Remember to save the file as XML 2003"><i class="glyphicon glyphicon-download"></i> UF FILE</a>
                                    <a class="btn rfq-butt" href="{{URL('/login')}}"><i><img src="{{URL('/')}}/assets/img/rfq.png" alt="" height="18"></i> RFQ TO KSU</a>
                                @else
                                    <button class="btn rfq-butt"  data-toggle="modal" data-target="#irModal" data-trigger="hover" title="Download internal request form"><i class="glyphicon glyphicon-download"></i> IR FORM</button>
                                    <a href="{{URL('/exportUf')}}" class="btn rfq-butt" data-trigger="hover" title="Download Unifield importation file: Remember to save the file as XML 2003"><i class="glyphicon glyphicon-download"></i> UF FILE</a>
                                    <button class="btn rfq-butt" data-toggle="modal" data-target="#rfqModal"><i><img src="{{URL('/')}}/assets/img/rfq.png" alt="" height="18"></i> RFQ TO KSU</button>
                                @endif
                            </div>
                        </div>
                    </div> 
                @endif
                
                <div class="row">
                    <div class="col-md-12">
                        <!-- Shopping Cart Items -->
                        <table class="shopping-cart">
                            <!-- Shopping Cart Item -->
                            @if (count($items)>0)
                                @foreach ($items as $item)
                                    <tr>
                                        <!-- Shopping Cart Item Image -->
                                        <td><a href="{{URL('/article')}}/{{$item->id}}"><img src="{{$item->attributes->pic}}" alt="Item Name" height="80"></a></td>
                                        <!-- Shopping Cart Item Description & Features -->
                                        <td>
                                            <div class="cart-item-title"><a href="{{URL('/article')}}/{{$item->id}}">{{$item->id}}</a></div>
                                            <div class="cart-item-title"><a href="{{URL('/article')}}/{{$item->id}}">{{$item->name}}</a></div>
                                        </td>
                                        <form id="update_form" action="{{URL('/update')}}" method="post">
                                            @csrf
                                            <td class="">
                                                <input id="comment" name="comment" class="form-control " type="text" value="{{$item->attributes->comment}}" placeholder="Add comment and press enter to update">
                                            </td>
                                            <!-- Shopping Cart Item Quantity -->
                                            <td class="quantity">
                                                <input id="quantity" name="quantity" class="form-control input-sm input-micro" type="text" value="{{$item->quantity}}">
                                            </td>
                                            <input type="hidden" name="fra" value="{{$item->attributes->fra}}">
                                            <input type="hidden" name="esp" value="{{$item->attributes->esp}}">
                                            <input type="hidden" name="article_code" value="{{$item->id}}">
                                            <input type="hidden" name="pic" value="{{$item->attributes->pic}}">
                                            <input type="hidden" name="unit" value="{{$item->attributes->unit}}">
                                        </form>
                                        <!-- Shopping Cart Item Price -->
                                        @if (!AUTH::guest())
                                            @if (session()->get('currency') == 'usd')
                                                <td class="price">{{number_format(Cart::get($item->id)->getPriceSum()*Session::get('KES_USD'),'2','.','')}} USD</td>
                                            @elseif(session()->get('currency') == 'eur')
                                                <td class="price">{{number_format(Cart::get($item->id)->getPriceSum()*Session::get('KES_EUR'),'2','.','')}} EUR</td>
                                            @elseif(session()->get('currency') == 'chf')
                                                <td class="price">{{number_format(Cart::get($item->id)->getPriceSum()*Session::get('KES_EUR'),'2','.','')}} CHF</td>
                                            @else
                                                <td class="price">{{Cart::get($item->id)->getPriceSum()}} KSH</td>
                                            @endif
                                        @endif
                                        {{-- <td class="price">{{Cart::get($item->id)->getPriceSum()}}</td> --}}
                                        <!-- Shopping Cart Item Actions -->
                                        <td class="actions">
                                            
                                            <a href="{{URL('/decarting')}}/{{$item->id}}" class="btn btn-xs btn-grey"><i class="glyphicon glyphicon-trash"></i></a>
                                            <a href="" class="btn btn-xs btn-grey"><i class="glyphicon glyphicon-refresh"></i></a>
                                        </td>
                                    </tr>
                                    <!-- End Shopping Cart Item -->
                                @endforeach
                                <a href="{{URL('/clear')}}" style="color:red" class="pull-right">Clear all</a>
                            @else
                                No Items in cart
                            @endif
                        </table>
                        <!-- End Shopping Cart Items -->
                    </div>
                </div>
                <div class="row">					
                    <!-- Shopping Cart Totals -->
                    @if (count($items)>0)
                        <div class="pull-right">
                            @if (!AUTH::guest())
                                <table class="cart-totals">
                                    <tr class="cart-grand-total">
                                        <td><b>Total</b></td>
                                        <td>
                                            @if (session()->get('currency') == 'usd')
                                                <b>{{number_format(Cart::getSubTotal()*Session::get('KES_USD'),'2','.','')}} USD</b>
                                            @elseif(session()->get('currency') == 'eur')
                                                <b>{{number_format(Cart::getSubTotal()*Session::get('KES_EUR'),'2','.','')}} EUR</b>
                                            @elseif(session()->get('currency') == 'chf')
                                                <b>{{number_format(Cart::getSubTotal()*Session::get('KES_EUR'),'2','.','')}} CHF</b>
                                            @else
                                                <b>{{number_format(Cart::getSubTotal(),'2','.','')}} KSH</td>
                                            @endif
                                            {{-- <b>{{Cart::getSubTotal()}}</b> --}}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td></td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    @endif
                    <div class="col-md-12">
                        <!-- Action Buttons -->
                        <div class="pull-left">
                            <a href="{{URL('/new-request')}}" class="btn"><i class="glyphicon glyphicon-plus-sign"></i> RFQ item not in catalogue</a>
                        </div>
                        @if (count($items)>0)
                            <div class="pull-right">
                                    @if (AUTH::guest())
                                        <a class="btn rfq-butt" href="{{URL('/login')}}" data-trigger="hover" title="Download internal request form"><i class="glyphicon glyphicon-download"></i> IR FORM</a>
                                        <a href="{{URL('/login')}}" class="btn rfq-butt" data-trigger="hover" title="Download Unifield importation file: Remember to save the file as XML 2003"><i class="glyphicon glyphicon-download"></i> UF FILE</a>
                                        <a class="btn rfq-butt" href="{{URL('/login')}}"><i><img src="{{URL('/')}}/assets/img/rfq.png" alt="" height="18"></i> RFQ TO KSU</a>
                                    @else
                                        <button class="btn rfq-butt"  data-toggle="modal" data-target="#irModal" data-trigger="hover" title="Download internal request form"><i class="glyphicon glyphicon-download"></i> IR FORM</button>
                                        <a href="{{URL('/exportUf')}}" class="btn rfq-butt" data-trigger="hover" title="Download Unifield importation file: Remember to save the file as XML 2003"><i class="glyphicon glyphicon-download"></i> UF FILE</a>
                                        <button class="btn rfq-butt" data-toggle="modal" data-target="#rfqModal"><i><img src="{{URL('/')}}/assets/img/rfq.png" alt="" height="18"></i> RFQ TO KSU</button>
                                    @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="irModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Internal request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                Please fill in this information first
                <form id="form-ir" action="{{URL('/exportIr')}}" method="post">
                    @csrf
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <label for="position">Position</label>
                    <input type="text" name="position" id="position" class="form-control" required>
                    <label for="purpose">Purpose</label>
                    <input type="text" name="purpose" id="purpose" class="form-control" placeholder="Why are you ordering these items?" required>
                    <label for="destination">Destination</label>
                    <input type="text" name="destination" id="destination" class="form-control" placeholder="Where/by who will the items be used?" required>
                    <label for="delivery">Delivery to</label>
                    <input type="text" name="delivery" id="delivery" class="form-control" placeholder="Name and department" required>
                    <label for="rdd">Requested Delivery Date</label>
                    <input type="date" name="rdd" id="rdd" class="form-control" required><br>
                    <label for="pic">Show pictures in IR</label>
                    <input type="checkbox" name="pic" id="pic">
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('form-ir').submit();">Download IR</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="rfqModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">RFQ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                Please fill in this information first
                <form id="form-rfq" action="{{URL('/exportRfq')}}" method="post">
                    @csrf
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" class="form-control" required>
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" class="form-control" required>
                    <label for="info">General additional information</label>
                    <textarea name="info" id="info" class="form-control" rows="4"></textarea>
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('form-rfq').submit();">Send RFQ</button>
                </div>
            </div>
            </div>
        </div>
@endsection