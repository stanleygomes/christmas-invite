@extends('layouts.email')

@section('title', 'Your account is up and running')

@section('body')

<h3>WELCOME</h3>

<p>Your account is up and running. Check your log in data, down bellow:</p>

<p><strong>NAME:</strong> {{ $toName }}</p>
<p><strong>EMAIL:</strong> {{ $toMail }}</p>
<p><strong>PASSWORD:</strong> {{ $password }}</p>

<p>You can access right here:</p>

<a href="{{ url('/dashboard') }}">
	<button style="padding:10px 15px;color:#fff;background:#60C060;border-radius:2px;border:0">CLIQUE ME</button>
</a>

@endsection