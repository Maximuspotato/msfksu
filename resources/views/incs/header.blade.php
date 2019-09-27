    <!-- Navigation & Logo-->
    <div class="mainmenu-wrapper">
        <div class="container">
            <div class="menuextras">
                <div class="extras">
                    <ul>
                        <li class="shopping-cart-items"><i><img src="{{URL('/')}}/assets/img/rfq.png" alt="" height="22"></i> <a href="{{URL('/cart')}}"><b id="cart_count">{{Cart::getContent()->count()}}</b> <b>item(s)</b></a></li>
                        <li>
                            <div class="dropdown choose-country">
                                @if (session()->get('language') == "")
                                    <a class="#" data-toggle="dropdown" href=""><img src="{{URL('/')}}/assets/img/flags/gb.png" alt="English"> EN <span class="fas fa-caret-down"></span></a>
                                @elseif(session()->get('language') == "en")
                                    <a class="#" data-toggle="dropdown" href=""><img src="{{URL('/')}}/assets/img/flags/gb.png" alt="English"> EN <span class="fas fa-caret-down"></span></a>
                                @elseif(session()->get('language') == "fr")
                                    <a class="#" data-toggle="dropdown" href=""><img src="{{URL('/')}}/assets/img/flags/fr.png" alt="French"> FR <span class="fas fa-caret-down"></span></a>
                                @elseif(session()->get('language') == "es")
                                    <a class="#" data-toggle="dropdown" href=""><img src="{{URL('/')}}/assets/img/flags/es.png" alt="Spanish"> ES <span class="fas fa-caret-down"></span></a>
                                @endif
                                <ul class="dropdown-menu" role="menu">
                                    <li role="menuitem"><a href="{{URL('/language')}}?lan=en"><img src="{{URL('/')}}/assets/img/flags/gb.png" alt="English"> EN</a></li>
                                    <li role="menuitem"><a href="{{URL('/language')}}?lan=fr"><img src="{{URL('/')}}/assets/img/flags/fr.png" alt="French"> FR</a></li>
                                    <li role="menuitem"><a href="{{URL('/language')}}?lan=es"><img src="{{URL('/')}}/assets/img/flags/es.png" alt="Spanish"> ES</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown choose-country">
                                @if (session()->get('currency') == "")
                                    <a class="#" data-toggle="dropdown" href="">KSH <span class="fas fa-caret-down"></span></a>
                                @elseif(session()->get('currency') == "ksh")
                                    <a class="#" data-toggle="dropdown" href="">KSH <span class="fas fa-caret-down"></span></a>
                                @elseif(session()->get('currency') == "usd")
                                    <a class="#" data-toggle="dropdown" href="">USD <span class="fas fa-caret-down"></span></a>
                                @elseif(session()->get('currency') == "eur")
                                    <a class="#" data-toggle="dropdown" href="">EUR <span class="fas fa-caret-down"></span></a>
                                @elseif(session()->get('currency') == "chf")
                                    <a class="#" data-toggle="dropdown" href="">CHF <span class="fas fa-caret-down"></span></a>
                                @endif
                                <ul class="dropdown-menu" role="menu">
                                    <li role="menuitem"><a href="{{URL('/currency')}}?curr=ksh">KSH</a></li>
                                    <li role="menuitem"><a href="{{URL('/currency')}}?curr=usd">USD</a></li>
                                    <li role="menuitem"><a href="{{URL('/currency')}}?curr=eur">EUR</a></li>
                                    <li role="menuitem"><a href="{{URL('/currency')}}?curr=chf">CHF</a></li>											
                                </ul>
                            </div>
                        </li>
                        @if (Auth::guest())
                            <li><a href="{{URL('/login')}}">Login <i class="fas fa-user"></i></a></li>
                        @else
                            <li>
                                <div class="dropdown choose-country">
                                    <a class="#" data-toggle="dropdown" href="" style="color:forestgreen">WELCOME, {{Auth::user()->position}} <i class="fas fa-caret-down"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="disabled" role="menuitem"><a href="{{URL('/favorites')}}"><i class="fas fa-heart"></i> My Favorites</a></li>
                                        <li class="disabled" role="menuitem"><a href="{{URL('/history')}}"><i class="fas fa-history"></i> My History</a></li>
                                        @if (Auth::user()->email == "msfocb-ksu-it@brussels.msf.org")
                                            <li role="menuitem"><a href="{{URL('/add-item')}}"><i class="fas fa-plus"></i> Add article</a></li> 
                                        @endif
                                        <li role="menuitem">
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                                    <i class="fas fa-sign-out-alt"></i> Logout
                                            </a>    
                                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>    
                                        </li>											
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <nav id="mainmenu" class="mainmenu">
                <div class="logo-wrapper">
                    <a href="{{URL('/')}}"><img src="{{URL('/')}}/assets/img/logo.png" alt="" height="75"></a>
                </div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                </button>
                <ul class="collapse navbar-collapse" id="myNavbar">
                    <li
                    @if ($active == "home")
                        class = "active"
                    @endif
                    >
                        <a href="{{URL('/')}}">Home</a>
                    </li>

                    <li
                    @if ($active == "about")
                        class = "active"
                    @endif
                    >
                        <a href="{{URL('/about')}}">About</a>
                    </li>

                    <li
                    @if ($active == "services")
                        class = "active"
                    @endif
                    class=""
                    >
                        <a href="{{URL('/services')}}">Services</a>
                    </li>
                    <li
                    @if ($active == "catalogue")
                        class = "active"
                    @endif
                    >
                        <a href="{{URL('/catalogue')}}">Catalogue</a>
                    </li>

                    <li
                    @if ($active == "contacts")
                        class = "active"
                    @endif
                    >
                        <a href="{{URL('/contacts')}}">Contacts</a>
                    </li>

                    <li
                    @if ($active == "hr")
                        class = "active"
                    @endif
                    class=""
                    >
                        <a href="{{URL('/hr')}}">Careers</a>
                    </li>

                    <li
                    @if ($active == "downloads")
                        class = "active"
                    @endif
                    class=""
                    >
                        <a href="{{URL('/downloads')}}">Downloads</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>