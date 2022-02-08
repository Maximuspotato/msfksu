<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Médecins Sans Frontières(MSF) Kenya Supply Unit</title>
    <meta name="description" content="Médecins Sans Frontières(MSF) Kenya Supply Unit - Supply Centre for the whole East Africa region">
    <meta name="keywords" content="Médecins Sans Frontières, MSF, Kenya, Medecins Sans Frontieres, KSU, Kenya Supply Unit, Humanitarian, NGO">
    <meta name =”robots” content=”index,follow”>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="Médecins Sans Frontières(MSF) Kenya Supply Unit - Supply Centre for the whole East Africa region">
    <meta property="og:type" content="{{URL('/')}}">
    <meta property="og:image" content="{{URL('/')}}/assets/img/logo.png">

    <link rel="stylesheet" href="{{URL('/')}}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{URL('/')}}/assets/css/icomoon-social.css">
    <link rel="stylesheet" href="{{URL('/')}}/ext/css/reports.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
    <link href="{{URL('/')}}/assets/css/fontawesome/fontawesome.css" rel="stylesheet">
    <link href="{{URL('/')}}/assets/css/fontawesome/solid.css" rel="stylesheet">
    <link href="{{URL('/')}}/assets/css/fontawesome/brands.css" rel="stylesheet">
    <link href="{{URL('/')}}/assets/css/jquery-editable-select.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/assets/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL('/')}}/assets/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{URL('/')}}/assets/css/magnify.css">

    <link rel="stylesheet" href="{{URL('/')}}/assets/css/leaflet.css" />
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/leaflet.ie.css" />
    <![endif]-->
    <link rel="stylesheet" href="{{URL('/')}}/assets/css/main.css">

    <link rel="icon" href="{{URL('/')}}/assets/img/logo.png" type="image/png" sizes="16x16">

    <link href="{{URL('/')}}/assets/client/fine-uploader-gallery.css" rel="stylesheet">

    <link href="{{URL('/')}}/assets/css/FeedEk.css" rel="stylesheet" type="text/css" />

    <script src="{{URL('/')}}/assets/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!};
    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TGQZQXG');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TGQZQXG"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
        <img id="twc" src="{{URL('/')}}/assets/img/flags/twc.jpg" alt="" height="250" style="display:none">
        @if (!Auth::guest())
            @php
                include_once(app_path() . '\outils\functions.php');
                $c = db_connect();
                global $tab_filter;
                //echo $c;
            @endphp
        @endif

        @include('incs.header')

        @include('incs.mgs')

        @yield('content')

        @include('incs.footer')

        @include('incs.scripts')

    </body>
</html>
