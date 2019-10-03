@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{$article->article_code}}</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <div class="row item">
                <!-- Product Image & Available Colors -->
                <div class="col-sm-6">
                    <div class="product-image-large image">
                        @foreach ($article->pic as $pic)
                            @if ($pic['pic'] == "default")
                                <a href="{{URL('/article')}}/{{$article->article_code}}"><img class="img-thumbnail zoom" src="{{URL('/')}}/assets/img/pics/default.png" data-magnify-src="{{URL('/')}}/assets/img/pics/default.png" alt="" ></a>
                            @else
                                <a href="{{URL('/article')}}/{{$article->article_code}}"><img class="img-thumbnail zoom" src="{{URL('/')}}/assets/img/pics/{{$pic['pic']}}.png" data-magnify-src="{{URL('/')}}/assets/img/pics/{{$pic['pic']}}.png" alt="" ></a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- End Product Image & Available Colors -->
                <!-- Product Summary & Options -->
                <div class="col-sm-6 product-details">
                    <h5>Description</h5>
                    <p>
                        @if (session()->exists("language"))
                            @if (session()->get("language") == "en")
                                {{$article->desc_eng}}
                            @elseif(session()->get("language") == "fr")
                                @if ($article->desc_fra == "")
                                    {{$article->desc_eng}}
                                @else
                                    {{$article->desc_fra}}
                                @endif
                            @elseif(session()->get("language") == "es")
                                @if ($article->desc_spa == "")
                                    {{$article->desc_eng}}
                                @else
                                    {{$article->desc_spa}}
                                @endif
                            @endif
                        @else
                            {{$article->desc_eng}}
                        @endif
                    </p>
                    <table class="shop-item-selections">
                        <form id="carting">
                            @csrf
                            <tr>
                                    <td><b>Quantity:</b></td>
                                    <td>
                                        <input type="number" name="quantity" class="form-control input-sm input-micro" value="1" min="1" required>
                                        <input type="hidden" name="article_code" value="{{$article->article_code}}">
                                        <input type="hidden" name="price" value="{{$article->price}}">
                                        <input type="hidden" name="name" value="{{$article->desc_eng}}">
                                        <input type="hidden" name="pic" value="{{URL('/')}}/assets/img/pics/{{$article->pic->first()['pic']}}.png">
                                        <input type="hidden" name="unit" value="{{$article->unit}}">
                                        <input type="hidden" name="lead_time" value="{{$article->lead_time}}">
                                        <input type="hidden" name="weight" value="{{$article->weight}}">
                                        <input type="hidden" name="volume" value="{{$article->volume}}">
                                        <input type="hidden" name="sud" value="{{$article->sud}}">
                                    </td>
                                </tr>
                                <!-- Add to Cart Button -->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <button id="add_rfq_butt" type="submit" class="btn btn"> Add to Request</button>

                                    </td>
                                </tr>
                        </form>
                    </table>
                    <div class="tabbable">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs product-details-nav">
                                <li class="active"><a href="#tab1" data-toggle="tab">Specification</a></li>
                                <li><a href="#tab2" data-toggle="tab">Details</a></li>
                            </ul>
                            <!-- Tab Content (Full Description) -->
                            <div class="tab-content product-detail-info">
                                <div class="tab-pane active" id="tab1">
                                    <table>
                                        <tr>
                                            <td>Article code</td>
                                            <td>{{$article->article_code}}</td>
                                        </tr>
                                        @if (!AUTH::guest())
                                            <tr>
                                                <td>Price</td>
                                                <td>
                                                    {{-- {{number_format($article->price,'2','.','')}}  --}}
                                                    @if (session()->get('currency') == 'usd')
                                                        {{number_format($article->price*Session::get('KES_USD'),'2','.','')}} USD
                                                    @elseif(session()->get('currency') == 'eur')
                                                        {{number_format($article->price*Session::get('KES_EUR'),'2','.','')}} EUR
                                                    @elseif(session()->get('currency') == 'chf')
                                                        {{number_format($article->price*Session::get('KES_EUR'),'2','.','')}} CHF
                                                    @else
                                                        {{$article->price}} KSH
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Price valid until</td>
                                            <td>{{$article->valid}}</td>
                                        </tr>
                                        <tr>
                                            <td>Stock</td>
                                            <td>{{$article->stock}}</td>
                                        </tr>
                                        @if ($article->stock == "No" || $article->stock == "no")
                                            <tr>
                                                <td>Lead time (RTS in KSU - weeks)</td>
                                                <td>{{$article->lead_time}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Unit</td>
                                            @if (empty($article->sud))
                                                <td>-</td>
                                            @else
                                                <td>{{$article->sud}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Standard Unit of Distribution</td>
                                            @if (empty($article->unit))
                                                <td>-</td>
                                            @else
                                                <td>{{$article->unit}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Weight</td>
                                            @if (empty($article->weight))
                                                <td>-</td>
                                            @else
                                                <td>{{$article->weight}}</td> 
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Volume</td>
                                            @if (empty($article->volume))
                                                <td>-</td>
                                            @else
                                                <td>{{$article->volume}}</td>
                                            @endif
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <h4>Product Details</h4>
                                    <p>
                                        @if (empty($article->details))
                                            No information available
                                        @else
                                            {!!$article->details!!}
                                        @endif
                                    </p>
    
                                </div>
                            </div>
                        </div>
                </div>
                <!-- End Product Summary & Options -->
                
                <!-- Full Description & Specification -->
                <div class="col-sm-12">
                    
                </div>
                <!-- End Full Description & Specification -->
            </div>
        </div>
    </div>
@endsection