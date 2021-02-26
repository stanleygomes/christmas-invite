@extends('layouts.email')

@section('title', 'Invitation confirmed')

@section('body')

<img src="{{ $message->embed(public_path().env('APP_URL_PREFIX').'uploads/events/'.$event_id.'/'.$event_id.'.png') }}" width="100%">

<h3>{{ $toName }}, thanks for your confirmation!</h3>

<div style="text-align:center">
    <p><strong>{{ $event_name }}</strong></p>
    <p><strong>Date:</strong> {{ $event_date ? $event_date->format('M d\n\d Y') : '' }} {{ $event_date && $event_date->format('H:i') != '00:00' ? ' | '.(int)$event_date->format('h').':'.$event_date->format('ia') : '' }}</p>
    <p><strong>Place:</strong> {{ $event_place }}</p>

    <br /><br />

    <p><strong>Menu selected:</strong> {{ $guest->guest_food }}</p>

    <p><strong>Guest:</strong> {{ $guest->companion == 1 ? 'Yes' : 'No' }}</p>
    @if($guest->companion == 1)
    <p><strong>Guest name:</strong> {{ $guest->companion_name }}</p>
    <p><strong>Guest menu selected:</strong> {{ $guest->companion_food }}</p>
    @endif

    <p><strong>Alergies:</strong> {{ $guest->allergies ? $guest->allergies : 'None' }}</p>
</div>

<a href="{{ route('web.confirm', ['token' => $token]) }}" style="text-decoration:none">
    <button style="padding:10px 15px;color:#fff;background:#60C060;border-radius:2px;border:0">Add to calendar</button>
</a>

<a href="https://www.google.com/maps/search/?api=1&query={{ utf8_encode($event_place) }}" style="text-decoration:none">
    <button style="padding:10px 15px;color:#fff;background:#647bce;border-radius:2px;border:0">Get directions</button>
</a>

@endsection