<!DOCTYPE html>
<html lang="pt-BR" ng-app="app">
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
        <meta name="description" content="@yield('page_description')"/>
        <meta name="keywords" content="@yield('page_keywords')"/>
        <meta name="robots" content="no-follow, no-index"/>
        <meta name="generator" content="NIPVP"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <link rel="shortcut icon" href="{{ env('APP_URL_PREFIX') }}img/logo-favicon.png?v={{ env('APP_VERSION') }}" type="image/gif"/>
        <link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/bootstrap.css?v={{ env('APP_VERSION') }}" type="text/css"/>
        <link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/general.css?v={{ env('APP_VERSION') }}" type="text/css"/>
        <link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/fontawesome.css?v={{ env('APP_VERSION') }}"/>
        <link rel="stylesheet" href="{{ env('APP_URL_PREFIX') }}css/lib/bootstrap-datepicker3.standalone.min.css?v={{ env('APP_VERSION') }}"/>

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        @yield('styles')

    </head>
    <body ng-controller="appController">

        <nav id="menu" data-spy="affix" data-offset-top="100" class="@yield('hide_navbar') navbar navbar-inverse navbar-fixed-top no-print grey" role="navigation">
            <div class="full-width navbar-header-content">
                <div class="container">
                    <div class="lleft pull-left">
                        <div class="full-width navbar-header">
                            <div id="showhide" class="text-left show-sidebar mainlogo type-action-sidebar">
                                <a href="{{ env('APP_URL_PREFIX') }}dashboard">
                                    <img src="{{ env('APP_URL_PREFIX') }}img/logo.png" class="logo logo-black"/>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="lright pull-right visible-xs">
                        <a href="javascript:void(0)" data-toggle="collapse" data-target="#navbarcollapse">
                            <span class="login"><strong>MENU</strong></span>
                        </a>
                    </div>
                    <div id="navbarcollapse" class="xs-full-width col-sm-12  pull-right collapse navbar-collapse">
                        <ul class="full-width menutop xs-text-center xs-no-margin nav navbar-nav side-nav">
                            <li class="xs-full-width item">
                                <a href="{{ env('APP_URL_PREFIX') }}dashboard/guests" class="@yield('menu_guest')">GUESTS</span></a>
                            </li>
                            <li class="xs-full-width item">
                                <a href="{{ env('APP_URL_PREFIX') }}dashboard/events" class="@yield('menu_event')">EVENTS</span></a>
                            </li>
                            <li class="xs-full-width item">
                                <a href="{{ env('APP_URL_PREFIX') }}dashboard/users" class="@yield('menu_user')">USERS</span></a>
                            </li>
                            <li class="dropdown item-user">
                                <a href="#" class="dropdown-toggle dropdown-item text-upper @yield('menu_profile')" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle icon"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="{{ env('APP_URL_PREFIX') }}dashboard/user">Profile</a></li> -->
                                    <li><a href="{{ env('APP_URL_PREFIX') }}dashboard/password/edit">Change my password</a></li>
                                    <li><a href="{{ env('APP_URL_PREFIX') }}dashboard/user/edit">Edit my account</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ env('APP_URL_PREFIX') }}auth/logout">Get out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div id="pagecontent" class="full-width main">
            <div class="container">
                <div class="col-sm-12">
                    @yield('content')
                    @include('layouts.footer')
                </div>
            </div>
    	</div>

        <!--
        <script src="{{ env('APP_URL_PREFIX') }}christmasinvite{{ env('APP_URL_PREFIX') }}christmasinvite{{ env('APP_URL_PREFIX') }}christmasinvite{{ env('APP_URL_PREFIX') }}js/vendor/angular/angular.min.js?v={{ env('APP_VERSION') }}"></script>

        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/angular/angular-resource.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/angular/angular-route.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/angular/angular-sanitize.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/angular/angular-ui-router.min.js?v={{ env('APP_VERSION') }}"></script>

        <script src="{{ env('APP_URL_PREFIX') }}js/app/app.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/services/bo.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/services/utils.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/controllers/usersController.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/controllers/sugarcaneInputController.js?v={{ env('APP_VERSION') }}"></script>
        -->

        <script src="{{ env('APP_URL_PREFIX') }}js/jquery.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/bootstrap.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/jquery.mask.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/jquery.autocomplete.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/myforms.js?v={{ env('APP_VERSION') }}"></script>

        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js?v={{ env('APP_VERSION') }}"></script>
        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/bootstrap-datepicker/bootstrap-datepicker.pt-BR.min.js?v={{ env('APP_VERSION') }}"></script>
        <!--
        <script src="{{ env('APP_URL_PREFIX') }}js/vendor/ui-bootstrap/ui-bootstrap-2.5.0.min.js?v={{ env('APP_VERSION') }}"></script>
        -->

        <script src="{{ env('APP_URL_PREFIX') }}js/main.js?v={{ env('APP_VERSION') }}"></script>

        <script src="{{ env('APP_URL_PREFIX') }}js/analytics.js?v={{ env('APP_VERSION') }}"></script>

        @yield('scripts')

    </body>
</html>
