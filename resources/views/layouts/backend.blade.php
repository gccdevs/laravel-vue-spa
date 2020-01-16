<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="0GpBXCAEuCSGEPme_w6P4Vi71VidxH8gdAHzM1LPyK8" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css" />
    <style>
        .no-shadow {
            border: 1px solid #bebebe !important;
            outline: none !important;
            box-shadow: none !important;
            border-radius: 0;
            background-color: transparent;
        }
        .no-shadow:focus, .no-shadow:active, .no-shadow:hover {
            border: 1px solid #4b5fe2 !important;
            background-color: initial !important;
        }
        input:-webkit-autofill {
            -webkit-fill-color: transparent !important;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>
<body>
<div class="anchor-login" style="top: 2%; right: 2%; position: absolute;text-transform: uppercase;">
    @if (Route::has('login'))
        @auth
            <a href="{{ url('/admin')  }}" style="color: white; text-transform: uppercase; text-decoration: none;font-size: 12px;font-weight: 700;letter-spacing: .1rem;">Dashboard</a>
        @else
            <a href="{{ route('login') }}" style="color: white; text-transform: uppercase; text-decoration: none;font-size: 12px;font-weight: 700;letter-spacing: .1rem;">Login</a>
        @endauth
    @endif
</div>

<div id="app">
    <div class="column" style="padding: 0 !important;">
        @yield('content')
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
</body>
</html>
