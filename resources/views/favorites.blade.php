@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>My History</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Shopping Cart Items -->
                        <table class="shopping-cart">
                            <!-- Shopping Cart Item -->
                            <tr>
                                <!-- Shopping Cart Item Image -->
                                <td class="image"><a href="page-product-details.html"><img src="{{URL('/')}}/assets/img/product1.jpg" alt="Item Name"></a></td>
                                <!-- Shopping Cart Item Description & Features -->
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">AFOOZYN0016</a></div>
                                </td>
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">LOREM IPSUM DOLOR</a></div>
                                </td>
                            </tr>
                            <!-- End Shopping Cart Item -->
                            <tr>
                                <td class="image"><a href="page-product-details.html"><img src="{{URL('/')}}/assets/img/product2.jpg" alt="Item Name"></a></td>
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">AFOOZYN0016</a></div>
                                </td>
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">LOREM IPSUM DOLOR</a></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="image"><a href="page-product-details.html"><img src="{{URL('/')}}/assets/img/product3.jpg" alt="Item Name"></a></td>
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">AFOOZYN0016</a></div>
                                </td>
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">LOREM IPSUM DOLOR</a></div>
                                </td>
                            </tr>
                        </table>
                        <!-- End Shopping Cart Items -->
                    </div>
                </div>
            </div>
        </div>
@endsection