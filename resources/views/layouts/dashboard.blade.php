<!DOCTYPE html>
<html lang="pt-BR" data-ng-app="website">
    <head>

        <title>@yield('page_title') - {{ env('APP_NAME') }}</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Script-Type" content="text/javascript"/>
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta http-equiv="content-language" content="pt-br"/>

        <meta name="theme-color" content="#F2F2F2">
        <meta name="msapplication-navbutton-color" content="#F2F2F2">
        <meta name="apple-mobile-web-app-status-bar-style" content="#F2F2F2">

        <meta name="author" content="{{ env('APP_AUTHOR') }}"/>
        <meta name="reply-to" content="{{ env('APP_AUTHOR_EMAIL') }}"/>
        <meta name="description" content="@yield('description')"/>
        <meta name="keywords" content="@yield('keywords')"/>
        <meta name="robots" content="follow"/>
        <meta name="generator" content="NIPVP"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <meta property="og:url" content=""/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content=""/>
        <meta property="og:description" content=""/>
        <meta property="og:image" content=""/>

        <meta name="google-site-verification" content=""/>

        <link rel="shortcut icon" href="{{ env('APP_URL_PREFIX') }}img/logo-favicon.png?v={{ env('APP_VERSION') }}" type="image/gif"/>

        <link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/bootstrap.css?v={{ env('APP_VERSION') }}"/>
        <link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/fontawesome.css?v={{ env('APP_VERSION') }}"/>
        <link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/website.css?v={{ env('APP_VERSION') }}"/>

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        @yield('styles')

    </head>
    <body>

        <div id="auth" class="full-width"></div>
            <div class="page">
                @yield('content')
            </div>
        </div>

        <script src="{{ env('APP_URL_PREFIX') }}js/jquery.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/bootstrap.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/jquery.mask.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/myforms.js?v={{ env('APP_VERSION') }}"></script>

        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/bootstrap-datepicker/bootstrap-datepicker.pt-BR.min.js?v={{ env('APP_VERSION') }}"></script>

        <script src="{{ env('APP_URL_PREFIX') }}js/main.js?v={{ env('APP_VERSION') }}"></script>

        <script src="{{ env('APP_URL_PREFIX') }}js/analytics.js?v={{ env('APP_VERSION') }}"></script>

        @yield('scripts')

    </body>
</html>
