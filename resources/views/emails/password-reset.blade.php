@extends('layouts.email')

@section('title', 'Reset your password')

@section('body')

<h3>Atualizar senha</h3>

<p>{{ $user->name }}, your password has been reseted. Your access data are at next.</p>

<p><strong>EMAIL:</strong> {{ $toName }}</p>
<p><strong>NEW PASSWORD:</strong> {{ $password }}</p>

<p>To access your account, click on the link bellow:</p>

<a href="{{ url('/dashboard') }}">
	<button style="padding:10px 15px;color:#fff;background:#60C060;border-radius:2px;border:0">YOUR LINK</button>
</a>

@endsection