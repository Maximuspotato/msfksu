    <!-- Navigation & Logo-->
    <div class="mainmenu-wrapper">
        {{-- <div class="ad text-center">
            <span style="color:white;"><b>Due to the curfew in Kenya at the moment our opening hours are from</b>&nbsp&nbsp</span>
            <span style="color:white; border:2px solid #ee0000; border-radius: 5px;">7am till 3.30pm</span> 
        </div> --}}
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
                                    @if (session()->get('position') == 'international')
                                        @if (session()->get('oc') != "")
                                            <a class="#" data-toggle="dropdown" href="">{{session()->get('oc')}} <i class="fas fa-caret-down"></i></a>
                                        @else
                                            <a class="#" data-toggle="dropdown" href="">SECTION <i class="fas fa-caret-down"></i></a>
                                        @endif
                                        <ul class="dropdown-menu" role="menu">
                                            <li role="menuitem"><a href="{{URL('/oc')}}?oc=all">ALL</a></li>
                                            <li role="menuitem"><a href="{{URL('/oc')}}?oc=OCB">OCB</a></li>
                                            <li role="menuitem"><a href="{{URL('/oc')}}?oc=OCBA">OCBA</a></li>
                                            <li role="menuitem"><a href="{{URL('/oc')}}?oc=OCA">OCA</a></li>
                                            <li role="menuitem"><a href="{{URL('/oc')}}?oc=OCG">OCG</a></li>
                                            <li role="menuitem"><a href="{{URL('/oc')}}?oc=OCP">OCP</a></li>								
                                        </ul>
                                    @else
                                        <a class="#" data-toggle="dropdown" href="">{{session()->get('oc')}} <i class="fas fa-caret-down"></i></a>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <div class="dropdown choose-country">
                                    @if (session()->get('position') == 'international' || session()->get('position') == 'hq')
                                        @if (session()->get('country_code') != "")
                                         <a class="#" data-toggle="dropdown" href="">{{session()->get('country')}} <i class="fas fa-caret-down"></i></a>
                                        @else
                                            <a class="#" data-toggle="dropdown" href="">COUNTRY <i class="fas fa-caret-down"></i></a>
                                        @endif
                                        
                                        <ul id="countries" class="dropdown-menu" role="menu" style=" max-width: 200px; max-height: 200px; overflow-y: scroll; overflow-x: scroll">
                                            <input type="text" id="myInput" onkeyup="search()" placeholder="Search country.." title="Type in country">
                                            <li role="menuitem"><a href="{{URL('/country')}}?country_code=all">ALL</a></li>
                                            @php
                                                $query_country = " SELECT DISTINCT PAY_CODE, PAY_NOM 
                                                                        FROM XN_PAYS        
                                                                        ORDER BY PAY_CODE ASC
                                                                    ";
                                                $stmt = oci_parse($c, $query_country);
                                                ociexecute($stmt, OCI_DEFAULT);
                                                $nrows = ocifetchstatement($stmt, $result_country,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
                                                
                                                foreach($result_country as $one_country){
                                                    echo '<li role="menuitem"><a href="'.URL("/country").'?country_code='.$one_country['PAY_CODE'].'&country='.$one_country['PAY_NOM'].'">'.$one_country['PAY_NOM'].'</a></li>';	
                                                }
                                            @endphp								
                                        </ul>
                                    @else
                                        <a class="#" data-toggle="dropdown" href="">{{session()->get('country_code')}} <i class="fas fa-caret-down"></i></a>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <div class="dropdown choose-country">
                                    <a class="#" data-toggle="dropdown" href="" style="color:forestgreen">WELCOME, {{Auth::user()->fname}} <i class="fas fa-caret-down"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="disabled" role="menuitem"><a href="{{URL('/favorites')}}"><i class="fas fa-heart"></i> My Favorites</a></li>
                                        <li class="disabled" role="menuitem"><a href="{{URL('/history')}}"><i class="fas fa-history"></i> My History</a></li>
                                        @if (Auth::user()->email == "msfocb-ksu-it@brussels.msf.org")
                                            <li role="menuitem"><a href="{{URL('/verify-emails')}}"><i class="fas fa-check"></i> Verify emails</a></li>
                                            <li role="menuitem"><a href="{{URL('/add-item')}}"><i class="fas fa-plus"></i> Add article</a></li>
                                        @endif
                                        @if (Auth::user()->email == "msfocb-ksu-it@brussels.msf.org" || Auth::user()->email == "msfocb-ksu-coord@brussels.msf.org" || Auth::user()->email == "msfocb-ksu-supplychainmanager@brussels.msf.org")
                                            <li role="menuitem"><a href="{{URL('/add-story')}}"><i class="fas fa-plus"></i> Add story</a></li>
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
                    @if (Auth::guest())
                        <li
                        @if ($active == "home")
                            class = "active"
                        @endif
                        >
                            <a href="{{URL('/')}}">Home</a>
                        </li>
                    @endif

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
                    @if ($active == "feedback")
                        class = "active"
                    @endif
                    >
                        <a href="{{URL('/feedback')}}">Feedback</a>
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
                    @if (!Auth::guest())
                        <li
                        @if ($active == "extranet")
                            class = "active"
                        @endif
                        class=""
                        >
                            <a href="{{URL('/extra_net')}}">Extranet</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>