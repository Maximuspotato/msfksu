@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>{{$title}}</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="container">
                <div class="row">
                    <aside class="col-sm-3">
                        <h3>Search</h3>
                        <div class="search-item">
                            <h5 class="">By Keyword</h5>
                            <form id="search_form" class="pb-3" action="{{Url('/catalogue')}}" method="GET">
                                <div class="input-group">
                                    {{-- <select name="search" id="editable-select" class="form-control" placeholder="Search" type="text" required>
                                        @if (count($items) > 0)
                                            @foreach ($items as $item)
                                                    @if (session()->get('language') == 'en')
                                                        <option value="{{$item->article_code}}">{{$item->article_code}} - {{$item->desc_eng}} &lt;span class="hide"&gt;{{$item->fam_desc}}&lt;/span&gt;</option>
                                                    @elseif(session()->get('language') == 'fr')
                                                        @if ($item->desc_fra == '')
                                                            <option value="{{$item->article_code}}">{{$item->article_code}} - {{$item->desc_eng}} &lt;span class="hide"&gt;{{$item->fam_desc}}&lt;/span&gt;</option>
                                                        @else
                                                            <option value="{{$item->article_code}}">{{$item->article_code}} - {{$item->desc_fra}} &lt;span class="hide"&gt;{{$item->fam_desc}}&lt;/span&gt;</option>
                                                        @endif
                                                    @elseif(session()->get('language') == 'es')
                                                        @if ($item->desc_spa == "")
                                                            <option value="{{$item->article_code}}">{{$item->article_code}} - {{$item->desc_eng}} &lt;span class="hide"&gt;{{$item->fam_desc}}&lt;/span&gt;</option>
                                                        @else
                                                            <option value="{{$item->article_code}}">{{$item->article_code}} - {{$item->desc_spa}} &lt;span class="hide"&gt;{{$item->fam_desc}}&lt;/span&gt;</option>
                                                        @endif
                                                    @elseif(session()->get('language') == '')
                                                        <option value="{{$item->article_code}}">{{$item->article_code}} - {{$item->desc_eng}} &lt;span class="hide"&gt;{{$item->fam_desc}}&lt;/span&gt;</option>
                                                    @endif
                                            @endforeach
                                        @endif
                                    </select> --}}
                                    <input name="search" class="form-control" placeholder="Search" type="text">
                                    <a class="btn"	onclick="event.preventDefault(); document.getElementById('search_form').submit();"><i class="fas fa-search"></i></a>
                                </div>
                            </form>
                        </div>
                        <div class="search-item">
                            <h5 class="">By Category</h5>
                            <form id="cat_form" action="{{url('/catalogue')}}" method="GET">
                                <div class="form-group">
                                    <select id="group" name="group" class="form-control" required>
                                        <option value="">All Groups</option>
                                        <option value="A">Administration / Office</option>
                                        <option value="C">Camps & Construction</option>
                                        <option value="D">Drugs</option>
                                        <option value="E">Medical equipment</option>
                                        <option value="I">Inventory lists / Checklists</option>
                                        <option value="K">Kits</option>
                                        <option value="L">Library</option>
                                        <option value="N">Nutrition</option>
                                        <option value="P">Program Support</option>
                                        <option value="S">Renewable medical suppplies</option>
                                        <option value="T">Transport</option>
                                        <option value="X">Services</option>
                                        <option value="Y">Mechanical spare parts</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="family" name="family" class="form-control" placeholder="Fam" required>
                                        <option value="">Please choose group</option>
                                    </select>
                                </div>
                                <div class="input-group">
                                    <a class="btn btn-lg centerin" onclick="event.preventDefault(); document.getElementById('cat_form').submit();"><i class="fas fa-search"></i></a>
                                </div>
                            </form>
                        </div>
                    </aside>
                    <main class="col-sm-9">
                        <div class="row">
                            @if (count($articles) > 0)
                                @foreach ($articles as $article)
                                    <div class="col-sm-3">
                                        <!-- Product -->
                                        <div class="shop-item">
                                            <!-- Product Image -->
                                            <div class="image">
                                                @foreach ($article->pic as $pic)
                                                    @if ($pic['pic'] == "default")
                                                        <a href="{{URL('/article')}}/{{$article->article_code}}"><img class="img-thumbnail zoom" src="{{URL('/')}}/assets/img/pics/default.png" data-magnify-src="{{URL('/')}}/assets/img/pics/default.png" alt="" ></a>
                                                    @else
                                                        <a href="{{URL('/article')}}/{{$article->article_code}}"><img class="img-thumbnail zoom" src="{{URL('/')}}/assets/img/pics/{{$pic['pic']}}.png" data-magnify-src="{{URL('/')}}/assets/img/pics/{{$pic['pic']}}.png" alt="" ></a>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="price">
                                                <a href="{{URL('/article')}}/{{$article->article_code}}">{{$article->article_code}}</a>
                                            </div>
                                            <!-- Product Title -->
                                            <div class="title">
                                                @if (session()->get('language') == 'en')
                                                    <h3><a href="{{URL('/article')}}/{{$article->article_code}}">{{$article->desc_eng}}</a></h3>
                                                @elseif(session()->get('language') == 'fr')
                                                    @if ($article->desc_fra == '')
                                                        <h3><a href="{{URL('/article')}}/{{$article->article_code}}">{{$article->desc_eng}}</a></h3>
                                                    @else
                                                        <h3><a href="{{URL('/article')}}/{{$article->article_code}}">{{$article->desc_fra}}</a></h3>
                                                    @endif
                                                @elseif(session()->get('language') == 'es')
                                                    @if ($article->desc_spa == "")
                                                        <h3><a href="{{URL('/article')}}/{{$article->article_code}}">{{$article->desc_eng}}</a></h3>
                                                    @else
                                                        <h3><a href="{{URL('/article')}}/{{$article->article_code}}">{{$article->desc_spa}}</a></h3>
                                                    @endif
                                                @elseif(session()->get('language') == '')
                                                    <h3><a href="{{URL('/article')}}/{{$article->article_code}}">{{$article->desc_eng}}</a></h3>
                                                @endif
                                            </div>
                                            {{-- <div class="title">
                                                <h3><a href="{{URL('/article')}}/{{$article->article_code}}">{{number_format($article->price,'2','.','')}} 
                                                @if (session()->get('currency') == 'usd')
                                                    USD
                                                @elseif(session()->get('currency') == 'eur')
                                                    EUR
                                                @elseif(session()->get('currency') == 'chf')
                                                    CHF
                                                @else
                                                    KSH
                                                @endif
                                                </a></h3>
                                            </div> --}}
                                            <!-- Product Description-->
                                            {{-- <div class="description">
                                                <p></p>
                                            </div> --}}
                                            <!-- Add to Cart Button -->
                                            <div class="actions">
                                                <a href="{{URL('/article')}}/{{$article->article_code}}" class="pull-left"><i class="fas fa-info-circle"></i></a>
                                                <form class="carting">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input type="hidden" name="article_code" value="{{$article->article_code}}">
                                                    <input type="hidden" name="price" value="{{$article->price}}">
                                                    <input type="hidden" name="name" value="{{$article->desc_eng}}">
                                                    <input type="hidden" name="fra" value="{{$article->desc_fra}}">
                                                    <input type="hidden" name="esp" value="{{$article->desc_esp}}">
                                                    <input type="hidden" name="pic" value="{{URL('/')}}/assets/img/pics/{{$article->pic->first()['pic']}}.png">
                                                    <input type="hidden" name="unit" value="{{$article->unit}}">
                                                    <input type="hidden" name="lead_time" value="{{$article->lead_time}}">
                                                    <input type="hidden" name="weight" value="{{$article->weight}}">
                                                    <input type="hidden" name="volume" value="{{$article->volume}}">
                                                    <input type="hidden" name="sud" value="{{$article->sud}}">
                                                    <button id="add_rfq_butt" class="rfq-butt btn pull-right" style="height:30px">Add to Request</button>
                                                </form>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        @if (!Auth::guest())
                                            @if (Auth::user()->name == "Admin")
                                                <div class="">
                                                    <form id="{{$article->article_code}}" action="{{URL('/article')}}/{{$article->article_code}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                    </form>
                                                    <button class="btn-success btn-sm" onclick="event.preventDefault(); document.getElementById('{{$article->article_code}}').submit();"> Delete</button>
                                                    <a href="{{URL('/article')}}/{{$article->article_code}}/edit" class="pull-right btn-success btn-sm"> Edit</a>
                                                    <div class="clearfix"></div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p>No items available</p><br>
                                <p>If you don’t find the item you are looking for in our catalogue, that doesn’t mean we can’t get it for you.<br>
                                    Use below link, fill the form, send, and our Customer Service Officer will come back to you within 3 workdays.
                                </p>
                                <a href="{{URL('/request-item')}}" class="btn"><i class="glyphicon glyphicon-plus-sign"></i> RFQ item not in catalogue</a>
                            @endif
                        </div>
                    </main>
                </div>
                <div class="pagination-wrapper ">
                    @if (isset($populars))
                        {{ $populars->appends(request()->query())->links() }}
                    @else
                        {{ $articles->appends(request()->query())->links() }}
                    @endif
                </div>
            </div>
        </div>
@endsection