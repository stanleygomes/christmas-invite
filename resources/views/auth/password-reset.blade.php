@extends('layouts.auth')

@section('page_title', 'Set a new password')

@section('content')

    <div id="auth" class="full-width">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="col-sm-12 no-padding no-margin">
                <div class="col-sm-12">
                    <div class="full-width text-center">
                        <a href="{{ env('APP_URL_PREFIX') }}dashboard">
                            <img src="{{ env('APP_URL_PREFIX') }}img/logo.png" class="brand"/>
                        </a>
                    </div>
                    <div class="full-width form">
                        @if(count($errors) > 0)
                        <div class="full-width alert alert-danger">
                            <button class="close" data-dismiss="alert">&times;</button>
                            {!! $errors->all()[1] !!}<br/>
                        </div>
                        @endif

                        @if (session('status'))
                        <div class="full-width alert alert-success">
                            <button class="close" data-dismiss="alert">&times;</button>
                            {!! session('status') !!}<br/>
                        </div>
                        @endif

                        <div class="full-width form-fields">
                            <form id="form" class="full-width formulary formulario validar" method="post" action="">
                                {!! csrf_field() !!}
                                @if(count($errors) > 0)
                                <div class="full-width alert alert-danger">
                                    <button class="close" data-dismiss="alert">&times;</button>
                                    {!! $errors->all()[1] !!}<br/>
                                </div>
                                @endif
                                <strong class="full-width text-center title">SET A NEW PASSWORD</strong>
                                <div class="full-width">
                                    <input type="password" autofocus="" class="full-width txt pass required" value="" name="password" autocomplete="off" placeholder="*****"/>
                                </div>
                                <div class="full-width">
                                    <input type="password" class="full-width txt pass required" value="" name="passwordrepeat" autocomplete="off" placeholder="Repeat"/>
                                </div>
                                <div class="full-width">
            						<button type="submit" class="btn btn-primary btn-block showloading">SAVE</button>
                                </div>
                                <div class="full-width text-center">
                                    <a href="{{ env('APP_URL_PREFIX') }}auth">
                                        <strong class="full-width iforgot">GO BACK TO LOG IN</strong>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection