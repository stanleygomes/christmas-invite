@extends(((\Auth::user()) ? 'layouts.adm' : 'layouts.dashboard' ))
@section("page_title", "Página não encontrada")

@section('content')
    <section id="error" class="full-width background-white padding-30 margin-top-30">
        <div class="full-width content">
            <div class="full-width page">
                <div class="full-width text-center padding-v-30 form-fields">
                    <img src="{{ env('APP_URL_PREFIX') }}img/404.gif" class="img404">
                    <h2><strong>WHOOPS! Page not found.</strong></h2>
                    <div class="full-width">
                        @if(isset(\Auth::user()->id))
                        <a href="{{ env('APP_URL_PREFIX') }}dashboard">
                        @else
                        <a href="{{ env('APP_URL_PREFIX') }}">
                        @endif
                            <strong class="btn margin-top-15 btn-primary">GO TO DASHBOARD</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
