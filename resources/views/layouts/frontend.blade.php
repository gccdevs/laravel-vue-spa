<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="0GpBXCAEuCSGEPme_w6P4Vi71VidxH8gdAHzM1LPyK8" />

    <link rel="canonical" href="{{ env('APP_URL') }}" />

    <meta property="og:type" content="website" />
    <meta property="og:title" content="墨尔本荣耀城教会" />
    <meta property="og:description" content=" - Glory City Church of Melbourne" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:site_name" content="GCC Hub" />
    <meta property="og:image" content="{{ asset('img/logo.jpg') }}" />
    <meta property="og:image:secure_url" content="{{ asset('img/logo.jpg') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="墨尔本荣耀城教会" />
    <meta name="twitter:description" content=" - Glory City Church of Melbourne" />  
    <meta name="twitter:site" content="@GCC Hub" />
    <meta name="twitter:image" content="{{ asset('img/logo.jpg') }}" />
    <meta name="twitter:creator" content="@GCC Hub" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.jpg') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    @routes
    <script type="application/javascript">
        var ALLOW_VUE_CACHE = "{{ env('ALLOW_VUE_CACHE') }}";
        var ENV = "{{ env('APP_ENV') }}";
        var Laravel = {};
        Laravel.apiToken = '';
        window.APP_URL = '{{env('APP_URL')}}';
        Laravel.APP_URL = '{{env('APP_URL')}}';
        Laravel.StripeKey = '{{ config('app.stripe.key') }}';
    </script>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<div id="app">
    @yield('frontendContent')
</div>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/frontend.js') }}"></script>
</body>
</html>
