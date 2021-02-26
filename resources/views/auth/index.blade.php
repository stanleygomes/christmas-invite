@extends('layouts.auth')

@section('page_title', 'LOG IN')

@section('content')

    <div id="auth" class="full-width">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="col-sm-12 no-padding no-margin">
                <div class="col-sm-12">
                    <div class="full-width text-center">
                        <a href="{{ env('APP_URL_PREFIX') }}">
                            <img src="{{ env('APP_URL_PREFIX') }}img/logo.png" class="brand"/>
                        </a>
                    </div>
                    <div class="full-width form">
                        @if(session('status'))
                        <div class="full-width margin-top-15 alert alert-success">
                            <i class="fa fa-check"></i> <b>{!! session('status') !!}</b>
                        </div>
                        @endif
                        @if(count($errors) > 0)
                        <div class="full-width alert alert-danger">
                            <button class="close" data-dismiss="alert">&times;</button>
                            {!! $errors->all()[1] !!}<br/>
                        </div>
                        @endif
                        <div class="full-width form-fields">
                            <form id="form" class="full-width formulario formulary validar" method="post" action="">
                                {!! csrf_field() !!}
                                <strong class="full-width text-center title">ENTER YOUR CREDENTIALS</strong>
                                <div class="full-width ">
                                    @if(count($errors) > 0 && count($errors->all()) > 1)
                                    <input type="email" class="full-width txt user required" name="email" autocomplete="off" placeholder="Email" value="{{ $errors->all()[2] }}"/>
                                    @else
                                    <input type="email" autofocus="" class="full-width txt user required" name="email" autocomplete="off" placeholder="Email" value=""/>
                                    @endif
                                </div>
                                <div class="full-width">
                                    <input type="password" class="full-width txt pass required" value="" name="password" autocomplete="off" placeholder="Password"/>
                                </div>
                                <div class="full-width">
            						<button type="submit" class="btn btn-primary btn-block showloading">LOG IN</button>
                                </div>
                                <div class="full-width text-center">
                                    <a href="{{ env('APP_URL_PREFIX') }}auth/password/request">
                                        <strong class="full-width iforgot">RECOVER PASSWORD</strong>
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