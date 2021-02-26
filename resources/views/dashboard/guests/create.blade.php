@extends('layouts.adm')
@section('menu_guest', 'active')
@section('page_title', 'Create guest')

@section('content')

<div class="full-width">
	<div class="col-sm-12 xs-no-padding xs-no-margin">
		<div id="go-back" class="full-width no-margin">
			<a href="{{ env('APP_URL_PREFIX') }}dashboard/guests">
				<div class="full-width title">
					<strong class="text-upper color-text">
						<i class="pull-left material-icons color-text icon">navigate_before</i>
						BACK TO GUESTS LIST
					</strong>
				</div>
			</a>
		</div>
		<form id="form" class="formulario panel-shadow background-white border-radius-5 padding-v-30 validar alt" role="form" method="post" action="{{ env('APP_URL_PREFIX') }}dashboard/guests/store">
			{!! csrf_field() !!}

			<div class="col-sm-12">
				@if(session('status'))
				<div class="full-width margin-top-15 alert alert-success">
					<i class="fa fa-check"></i> <b>{!! session('status') !!}</b>
				</div>
				@endif

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
				<h3 class="full-width text-left border-bottom-2 padding-15 no-margin">Create guest</h3>
			</div>

			<div class="full-width margin-top-15"></div>
			<div class="col-sm-4">
				<div class="form-group alt">
					<label class="titulo">Event*</label>
					<select name="event_id" class="full-width required no-text-indent txt">
						@foreach($events as $event)
						<option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="full-width margin-top-15"></div>
			<div class="col-sm-6">
				<div class="form-group alt">
					<label class="titulo">Name*</label>
			        <input type="text" autofocus="" name="name" class="txt required form-control" placeholder="" value=""/>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group alt">
					<label class="titulo">e-Mail (to send invite)*</label>
			        <input type="text" name="email" class="txt required form-control" placeholder="" value=""/>
				</div>
			</div>
			<input type="hidden" name="send" value="on"/>
			<div class="full-width">
				<div class="col-sm-3">
					<div class="full-width margin-top-15 margin-bottom-15">
						<button type="submit" class="full-width btn btn-primary showloading">CONTINUE</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection
