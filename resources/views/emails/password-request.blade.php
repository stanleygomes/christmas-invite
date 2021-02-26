@extends('layouts.email')

@section('title', 'Recover password')

@section('body')

<h3>PASSWORD RECOVER</h3>

<p>Someone, maybe you, has requested a password change. If it's You, access the link to recover.</p>

<a href="{{ route('auth.password.reset', ['token' => $token]) }}">
	<button style="padding:10px 15px;color:#fff;background:#60C060;border-radius:2px;border:0">YOUR LINK</button>
</a>

<p>If it's not You, just ignore this message. Your account is safe.</p>

@endsection