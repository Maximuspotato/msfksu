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
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">AFOOZYN0016 (LOREM IPSUM DOLOR)</a></div>
                                </td>
                                <!-- Shopping Cart Item Quantity -->
                                <td class="quantity">
                                    <input class="form-control input-sm input-micro" type="text" value="1" disabled>
                                </td>
                                <!-- Shopping Cart Item Price -->
                                <td class="price">$999.99</td>
                            </tr>
                            <!-- End Shopping Cart Item -->
                            <tr>
                                <td class="image"><a href="page-product-details.html"><img src="{{URL('/')}}/assets/img/product2.jpg" alt="Item Name"></a></td>
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">AFOOZYN0016 (LOREM IPSUM DOLOR)</a></div>
                                </td>
                                <td class="quantity">
                                    <input class="form-control input-sm input-micro" type="text" value="1" disabled>
                                </td>
                                <td class="price">$999.99</td>
                            </tr>
                            <tr>
                                <td class="image"><a href="page-product-details.html"><img src="{{URL('/')}}/assets/img/product3.jpg" alt="Item Name"></a></td>
                                <td>
                                    <div class="cart-item-title"><a href="{{URL('/item')}}">AFOOZYN0016 (LOREM IPSUM DOLOR)</a></div>
                                </td>
                                <td class="quantity">
                                    <input class="form-control input-sm input-micro" type="text" value="1" disabled>
                                </td>
                                <td class="price">$999.99</td>
                            </tr>
                        </table>
                        <!-- End Shopping Cart Items -->
                    </div>
                </div>
            </div>
        </div>
@endsection