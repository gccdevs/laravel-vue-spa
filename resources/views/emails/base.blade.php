<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        .page-logo {
            position: relative;
            margin-left: auto;
            margin-right: 15px;
            width: 97px;
            max-height: 100px;
            height: 100%;
        }
        .page-logo__wrap {
            position: absolute;
            z-index: 12;
            width: 100px;
            height: 100%;
        }
        .page-logo__img {
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            padding-bottom: 54.66%;
            /*background-image: url("../images/logo--short.png");*/
        }
        .email-wrap {
            position: relative;
            padding-top: 25px;
        }
        .email-footer {
            padding: 5px 0;
            color: white;
            font-weight: 700;
            background-image: linear-gradient(141deg, #1f191a 0%, #363636 71%, #46403f 100%);
        }
        .email-quotation {
            margin-top: 10px;
            padding: 0 15px;
            color: #4a4a4a;
            border-left: 0.25em solid #dfe2e5;
            font-style: italic;
        }
        .email-funding__img-wrap {
            padding-top: 30px;
            max-width: 100%;
        }
        .email-funding__img {
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 54.26%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="email-wrap">
        <div class="page-logo">
            <div class="page-logo__wrap">
                <?php if (env('APP_URL') != 'local') {
                    $path = asset('img/logo--main.png');
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                } else {
                    $base64 = asset('img/logo--main.png');
                }
                ?>
                <div class="page-logo__img" :class="type ? type: ''"
                     style="background-image: url('{{ $base64  }}')"></div>
            </div>
        </div>
        <div class="email-main">
            @yield('content')
        </div>
    </div>
</div>

<div class="email-footer">
    <div class="container">
        © Glory City Church of Melbourne Inc. 2018
    </div>
</div>
</body>
</html>
