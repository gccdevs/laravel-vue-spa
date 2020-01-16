<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="0GpBXCAEuCSGEPme_w6P4Vi71VidxH8gdAHzM1LPyK8" />

    <link rel="canonical" href="{{ env('APP_URL') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="GCC Hub" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:site_name" content="GCC Hub" />
    <meta property="og:description" content="荣耀城教会欢迎你" />
    <meta property="og:image" content="{{ asset('img/logo--main.png') }}" />
    <meta property="og:image:secure_url" content="{{ asset('img/logo--main.png') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="GCC Hub" />
    <meta name="twitter:description" content="荣耀城教会欢迎你" />
    <meta name="twitter:site" content="@GCC Hub" />
    <meta name="twitter:image" content="{{ asset('img/logo--main.png') }}" />
    <meta name="twitter:creator" content="@GCC Hub" />

    <title>Hub - GCC</title>
    <link rel="shortcut icon" href="{{ asset('img/logo--short.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: white;
            /*color: #636b6f;*/
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .swiss {
            max-width: 300px;
            opacity: 0.2;
        }
        #welcome {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            /*padding-bottom: 3%;*/
        }

    </style>
    <style>
        .page-logo {
            position: absolute;
            width: 97px;
            max-height: 100px;
            height: 100%;
        }
        .page-logo__wrap {
            position: absolute;
            z-index: 12;
            top: 30px;
            left: 30px;
            width: 100%;
            height: 100%;
        }
        .page-logo__img {
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            padding-bottom: 54.66%;
            background-image: url("../images/logo--short.png");
        }
    </style>
</head>
<body background="{{ asset('img/cool-bg.svg') }}" style="background-repeat: no-repeat; background-size: cover;">
{{--<video autoplay muted loop id="welcome">--}}
{{--<source src="{{ asset('video/welcome.mp4') }}" type="video/mp4">--}}
{{--</video>--}}

<div class="page-logo">
    <div class="page-logo__wrap">
        <div class="page-logo__img" :class="type ? type: ''"></div>
    </div>
</div>

<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ app()->getLocale() . '/admin' }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}" style="color: black;">Login</a>
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
        </div>

        <div class="links">
            <h1 style="color: black;font-size: 48px;">Central Hub</h1>
        </div>
    </div>
</div>
</body>
</html>
