@extends('layouts.email')

@section('title', 'YOU\'RE INVITED')

@section('body')

<img src="{{ $message->embed(public_path().env('APP_URL_PREFIX').'uploads/events/'.$event_id.'/'.$event_id.'.png') }}" width="100%">

<h3>{{ $toName }}, will you join us?</h3>

<div style="text-align:center">
    <p><strong>{{ $event_name }}</strong></p>
    <p><strong>Date:</strong> {{ $event_date ? $event_date->format('M d\n\d Y') : '' }}</p>
    <p><strong>Start time:</strong> {{ $event_date && $event_date->format('H:i') != '00:00' ? (int)$event_date->format('h').':'.$event_date->format('ia') : '' }}</p>
    <p><strong>Place:</strong> {{ $event_place }}</p>
    <p><strong>Dress to impress</strong></p>
</div>

<a href="{{ route('web.confirm', ['token' => $token]) }}" style="text-decoration:none">
    <button style="padding:10px 15px;color:#fff;background:#60C060;border-radius:2px;border:0">CONFIRM PRESENCE</button>
</a>

<br>

<p>
    or copy and go to the link bellow: <br>
    <a href="{{ route('web.confirm', ['token' => $token]) }}">
        {{ route('web.confirm', ['token' => $token]) }}
    </a>
</p>

<a href="https://www.google.com/maps/search/?api=1&query={{ utf8_encode($event_place) }}" style="text-decoration:none">
    <button style="padding:10px 15px;color:#fff;background:#647bce;border-radius:2px;border:0">Get directions</button>
</a>

@endsection