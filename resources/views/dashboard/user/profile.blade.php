@extends('layouts.adm')

@if($user->id == Auth::user()->id)
	@section('menu_profile', 'active')
@else
	@section('menu_user', 'active')
@endif

@if($user)
	@section('page_title', $user->name.' Profile')
@else
	@section('page_title', 'Profile')
@endif

@section('content')

<div id="user" class="full-width margin-top-30">

	@if(session('status'))
		<div class="col-sm-6 col-sm-offset-3">
			<div class="full-width alert alert-success">
				<i class="fa fa-check"></i> <b>{!! session('status') !!}</b>
			</div>
		</div>
	@endif

	@if(count($user) == 0){
	<div class="full-width panel-shadow background-white padding-30 border-radius-5 content">
		<div id="strong-alert" class="full-width text-center">
			<h3><strong class="full-width title">I'm sorry...</strong></h3>
			<span class="full-width margin-top-15 subtitle">Couldn't find this user...</span>
		</div>
	</div>
	@else
	<div class="col-sm-12">
			<div id="go-back" class="full-width no-margin">
				<a href="/dashboard/users">
					<div class="full-width title">
						<strong class="text-upper color-text">
							<i class="pull-left material-icons color-text icon">navigate_before</i>
							BACK TO USERS LIST
						</strong>
					</div>
				</a>
			</div>
		<div class="full-width panel-shadow background-white padding-30 border-radius-5 xs-no-margin content">
			<div class="full-width margin-top-15 text-center">
				<img src="{{ env('APP_URL_PREFIX') }}img/default-user.png" class="circle-area photo"/>
				<div class="full-width margin-top-30">
					<strong class="text-upper">{{ $user->name }}</strong>
				</div>
				<div class="full-width margin-top-15 data">
					<span class="full-width item">{{ $user->email }}</span>
					<span class="full-width item">{{ $user->phone }}</span>
					<span class="full-width item">{{ $address }}</span>
				</div>
				<div class="full-width margin-top-15 data">
					<a href="/dashboard/user/edit/{{ $user->id }}">
						<button class="btn btn-grey btn-min">EDIT</button>
					</a>
					@if($user->id == Auth::user()->id)
					<a href="/dashboard/password/edit">
						<button class="btn btn-grey btn-min">CHANGE PASSWORD</button>
					</a>
					@else
					<a href="/dashboard/password/reset/{{ $user->id }}" class="confirmdelete">
						<button class="btn btn-grey btn-min">RESET PASSWORD</button>
					</a>
					@endif
					<a href="/dashboard/user/status/{{ $user->status == 1 ? 'disable' : 'enable' }}/{{ $user->id }}">
						<button class="btn btn-{{ $user->status == 1 ? 'danger' : 'success' }} display-hover btn-min">{{ $user->status == 1 ? 'DEACTIVATE ACCOUNT' : 'ACTIVATE ACCOUNT' }}</button>
					</a>
					@if($user->type == 0)
					<a href/dashboard/user/status/delete/{{ $user->id }}" class="confirmdelete">
						<button class="btn btn-grey btn-min">EXCLUIR</button>
					</a>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif
</div>

@endsection