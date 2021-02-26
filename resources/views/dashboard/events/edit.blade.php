@extends('layouts.adm')
@section('menu_event', 'active')
@section('page_title', 'Edit event')

@section('content')

<div class="full-width">
	<div class="col-sm-12 xs-no-padding xs-no-margin">
		<div id="go-back" class="full-width no-margin">
			<a href="{{ env('APP_URL_PREFIX') }}dashboard/events">
				<div class="full-width title">
					<strong class="text-upper color-text">
						<i class="pull-left material-icons color-text icon">navigate_before</i>
						BACK TO EVENTS LIST
					</strong>
				</div>
			</a>
		</div>
		<form id="form" class="formulario panel-shadow background-white border-radius-5 padding-v-30 validar alt" role="form" method="post" action="{{ env('APP_URL_PREFIX') }}dashboard/events/update/{{ $event->id }}">
			{!! csrf_field() !!}

			<div class="col-sm-12">
				@if (count($errors) > 0)
				<div class="full-width margin-top-15 alert alert-danger">
					<button class="close" data-dismiss="alert">&times;</button>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{!! $error !!}</li>
						@endforeach
					</ul>
				</div>
				@endif
			</div>

			<div class="col-sm-12">
				<h3 class="full-width text-left border-bottom-2 padding-15 no-margin">Edit event</h3>
			</div>

			<div class="col-sm-6">
				<div class="form-group alt">
					<label class="titulo">Name*</label>
			        <input type="text" autofocus="" name="name" class="txt required form-control" placeholder="" value="{{ $event->name }}"/>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group alt">
					<label class="titulo">Date*</label>
			        <input type="text" name="date" class="txt required maskdate form-control" placeholder="__/__/____" value="{{ $event->date ? $event->date->format('d/m/Y') : '' }}"/>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group alt">
					<label class="titulo">Time*</label>
			        <input type="text" name="time" class="txt required masktime form-control" placeholder="__:__" value="{{ $event->date ? $event->date->format('H:i') : '' }}"/>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group alt">
					<label class="titulo">Place*</label>
			        <input type="text" name="place" class="txt required form-control" placeholder="" value="{{ $event->place }}"/>
				</div>
			</div>
			<div class="full-width margin-top-15">
				<div class="col-sm-3">
					<div class="full-width margin-bottom-15 margin-top-15">
						<button type="submit" class="full-width btn btn-primary showloading">SAVE</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection
