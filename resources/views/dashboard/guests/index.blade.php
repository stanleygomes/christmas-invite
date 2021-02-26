@extends('layouts.adm')
@section('menu_guest', 'active')
@section('page_title', 'Guests')

@section('content')

<div class="full-width list">
	<div class="col-sm-12 xs-no-margin xs-no-padding">
		<div class="col-sm-12 xs-no-margin xs-no-padding">

			@include('dashboard.guests.resume')

			{{--
			<div class="full-width margin-top-15"></div>
			@include('dashboard.guests.dashboard')
			--}}

			<form id="searchform" class="formulario validar alt margin-top-15" role="form" method="get" action="{{ env('APP_URL_PREFIX') }}dashboard/guests/search">
				{!! csrf_field() !!}

				<div class="full-width">
					<h3 class="full-width padding-15">
						<div class="col-sm-12">
							<div class="color-black col-sm-12">
								<strong>Search</strong>
							</div>
						</div>
					</h3>
					<div class="full-width panel-shadow background-white padding-30 border-radius-5">
						<div class="col-sm-4">
							<div class="form-group alt">
								<label class="titulo">Event*</label>
								<select name="event_id" class="full-width required no-text-indent txt">
									@foreach($events as $event)
									<option value="{{ $event->id }}" {{ old('event_id') == $event->id || $filter['event_id'] == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group alt">
								<label class="titulo">Name</label>
								<input type="text" name="name" class="txt focus form-control" placeholder="" value="{{ $filter['name'] or '' }}" />
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group alt">
								<label class="titulo">Status*</label>
								<select name="status_id" class="full-width required no-text-indent txt">
									<option value="0" {{ old('status_id') == 0 ? 'selected' : '' }}>All</option>
									@foreach($historyStatus as $status)
									<option value="{{ $status->id }}" {{ old('status_id') == $status->id || $filter['status_id'] == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-1">
							<div class="form-group alt">
								<label class="full-width titulo">&nbsp;</label>
								<button class="btn btn-min btn-icon btn-dark pull-right" type="submit">
									<i class="material-icons pull-right">search</i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>

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

			<div id="list" class="full-width">
				<div class="full-width xs-text-center page-title">
					<div class="col-sm-12">
						<div class="col-sm-6 col-xs-6">
							<h3 class="color-black title">
								<strong>Guests
									<!--/</strong><span>Event name</span>-->
							</h3>
						</div>
						<div class="col-sm-6 col-xs-6 text-right xs-text-center">
							<div class="btn btn-transparent btn-transparent-primary showsearch">
								<i class="material-icons pull-right">search</i>
							</div>
							@if(isset($filter['event_id']))
							<a href="{{ env('APP_URL_PREFIX') }}dashboard/guests/download/{{$filter['event_id']}}" data-toggle="tooltip" title="Download all the guests data">
								@else
								<a href="{{ env('APP_URL_PREFIX') }}dashboard/guests/download" data-toggle="tooltip" title="Download all the guests data">
									@endif
									<div class="btn btn-transparent btn-transparent-primary">
										<span>DOWNLOAD</span>
									</div>
								</a>
								<a href="{{ env('APP_URL_PREFIX') }}dashboard/guests/create">
									<div class="btn btn-primary">CREATE</div>
								</a>
						</div>
					</div>
				</div>
				@if($guests->count() == 0)
				<div class="col-sm-6 col-sm-offset-3">
					<div id="center-alert" class="full-width text-center" class="content">
						<img src="{{ env('APP_URL_PREFIX') }}img/empty-box.png" class="image" style="width:150px" />
						<div class="full-width title-medium">NO INVITATIONS HERE...</div>
					</div>
				</div>
				@else
				<div class="full-width panel-shadow background-white border-radius-5">
					<div class="col-sm-12">
						<div class="full-width line xs-hidden">
							<div class="col-sm-3 xs-text-center title">
								<span class="full-width sub">Name</span>
							</div>
							<div class="col-sm-4">
								<span class="full-width sub">Email</span>
							</div>
							<div class="col-sm-2">
								<span class="full-width sub">Status</span>
							</div>
							<div class="col-sm-3">
								<span class="full-width sub">Actions</span>
							</div>
						</div>
						@foreach($guests as $key => $guest)
						<div class="full-width line">
							<div class="col-sm-3 xs-text-center title">
								<strong class="full-width main">{{ $guest->name }}</strong>
								<em style="font-size: 14px;">{{ $guest->event_name }}</em>
							</div>
							<div class="col-sm-4">
								<strong class="full-width main">{{ $guest->email }}</strong>
							</div>
							<div class="col-sm-2">
								<span class="pull-left margin-top-15 label label-{{ $guest->status_color }}">{{ $guest->status_name }}</span>
							</div>
							<div class="col-sm-3 text-left xs-text-center options">
								<div class="display-inline-hover">
									@if ($guest->status_id == 1)
									<!--
									<a href="{{ env('APP_URL_PREFIX') }}dashboard/guests/resend-invite/{{ $guest->id }}">
										<button class="btn btn-transparent btn-min">RE-SEND</button>
									</a>
									<a href="{{ env('APP_URL_PREFIX') }}dashboard/guests/edit/{{ $guest->id }}">
										<button class="btn btn-transparent btn-min">EDIT</button>
									</a>
									-->
									@endif
									<a href="{{ env('APP_URL_PREFIX') }}dashboard/guests/delete/{{ $guest->id }}" class="confirmdelete">
										<button class="btn btn-transparent btn-transparent-danger btn-min">DELETE</button>
									</a>
								</div>
							</div>
						</div>
						@endforeach
						{!! $guests->render() !!}
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

@yield('scriptschart')

@endsection