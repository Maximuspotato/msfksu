@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Search</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row">
                <aside class="col-sm-3">
                    <h3>Search</h3>
                    <div class="shop-item">
                        <h5 class="">By Keyword</h5>
                        <form class="pb-3">
                            <div class="input-group">
                                <input class="form-control" placeholder="Search" type="text">
                                <a class="btn"	href="{{URL('/search')}}"><i class="fas fa-search"></i></a>
                            </div>
                        </form>
                    </div>
                    <div class="shop-item">
                        <h5 class="">By Category</h5>
                        <form class="">
                            <div class="form-group">
                                <select name="group" class="form-control">
                                    <option value="">All Groups</option>
                                    <option value="">Administration / Office</option>
                                    <option value="">Camps & Construction</option>
                                    <option value="">Drugs</option>
                                    <option value="">Medical equipment</option>
                                    <option value="">Inventory lists / Checklists</option>
                                    <option value="">Kits</option>
                                    <option value="">Library</option>
                                    <option value="">Nutrition</option>
                                    <option value="">Program Support</option>
                                    <option value="">Renewable medical suppplies</option>
                                    <option value="">Transport</option>
                                    <option value="">Services</option>
                                    <option value="">Mechanical spare parts</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="group" class="form-control">
                                    <option value="">All Families</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <a class="btn btn-lg centerin"	href="{{URL('/search')}}"><i class="fas fa-search"></i></a>
                            </div>
                        </form>
                    </div>
                </aside>
                <main class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Product -->
                            <div class="shop-item">
                                <!-- Product Image -->
                                <div class="image">
                                    <a href="{{URL('/item')}}"><img src="{{URL('/')}}/assets/img/product1.jpg" alt="Item Name"></a>
                                </div>
                                <!-- Product Title -->
                                <div class="title">
                                    <h3><a href="{{URL('/item')}}">Lorem ipsum dolor</a></h3>
                                </div>
                                <div class="price">
                                    <a href="{{URL('/item')}}">AFOOZYN0016</a>
                                </div>
                                <div class="title">
                                    <h3><a href="{{URL('/item')}}">999.09 $</a></h3>
                                </div>
                                <!-- Product Description-->
                                <div class="description">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mattis, nulla id pretium malesuada, dui est laoreet risus, ac rhoncus eros diam id odio.</p>
                                </div>
                                <!-- Add to Cart Button -->
                                <div class="actions">
                                    <a href="{{URL('/cart')}}" class="btn"><i class="icon-shopping-cart icon-white"></i> Add to Cart</a>
                                </div>
                                <div class="">
                                    <a href="" class="pull-left btn-danger btn-lg"><i class="icon-shopping-cart icon-white"></i> Delete</a>
                                    <a href="" class="pull-right btn-primary btn-lg"><i class="icon-shopping-cart icon-white"></i> Edit</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- End Product -->
                        </div>
                        <div class="col-sm-12">
                            <div class="shop-item">
                                <div class="image">
                                    <a href="{{URL('/item')}}"><img src="{{URL('/')}}/assets/img/product2.jpg" alt="Item Name"></a>
                                </div>
                                <div class="title">
                                    <h3><a href="{{URL('/item')}}">Lorem ipsum dolor</a></h3>
                                </div>
                                <div class="price">
                                    <a href="{{URL('/item')}}">AFOOZYN0016</a>
                                </div>
                                <div class="title">
                                    <h3><a href="{{URL('/item')}}">999.09 $</a></h3>
                                </div>
                                <div class="description">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mattis, nulla id pretium malesuada, dui est laoreet risus, ac rhoncus eros diam id odio.</p>
                                </div>
                                <div class="actions">
                                    <a href="{{URL('/cart')}}" class="btn"><i class="icon-shopping-cart icon-white"></i> Add to Cart</a>
                                </div>
                                <div class="">
                                    <a href="" class="pull-left btn-danger btn-lg"><i class="icon-shopping-cart icon-white"></i> Delete</a>
                                    <a href="" class="pull-right btn-primary btn-lg"><i class="icon-shopping-cart icon-white"></i> Edit</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="shop-item">
                                <div class="image">
                                    <a href="{{URL('/item')}}"><img src="{{URL('/')}}/assets/img/product3.jpg" alt="Item Name"></a>
                                </div>
                                <div class="title">
                                    <h3><a href="{{URL('/item')}}">Lorem ipsum dolor</a></h3>
                                </div>
                                <div class="price">
                                    <a href="{{URL('/item')}}">AFOOZYN0016</a>
                                </div>
                                <div class="title">
                                    <h3><a href="{{URL('/item')}}">999.09 $</a></h3>
                                </div>
                                <div class="description">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mattis, nulla id pretium malesuada, dui est laoreet risus, ac rhoncus eros diam id odio.</p>
                                </div>
                                <div class="actions">
                                    <a href="{{URL('/cart')}}" class="btn"><i class="icon-shopping-cart icon-white"></i> Add to Cart</a>
                                </div>
                                <div class="">
                                    <a href="" class="pull-left btn-danger btn-lg"><i class="icon-shopping-cart icon-white"></i> Delete</a>
                                    <a href="" class="pull-right btn-primary btn-lg"><i class="icon-shopping-cart icon-white"></i> Edit</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div class="pagination-wrapper ">
                <ul class="pagination pagination-lg">
                    <li class="disabled"><a href="#">Previous</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">6</a></li>
                    <li><a href="#">7</a></li>
                    <li><a href="#">8</a></li>
                    <li><a href="#">9</a></li>
                    <li><a href="#">10</a></li>
                    <li><a href="#">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection