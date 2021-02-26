@extends('layouts.adm')
@section('menu_user', 'active')
@section('page_title', 'Edit user')

@section('content')

<div class="full-width" ng-controller="usersController" ng-init="userInit()">
	<div class="col-sm-12 xs-no-padding xs-no-margin">
		<div id="go-back" class="full-width no-margin">
			<a href="{{ env('APP_URL_PREFIX') }}dashboard/users">
				<div class="full-width title">
					<strong class="text-upper color-text">
						<i class="pull-left material-icons color-text icon">navigate_before</i>
						BACK TO USERS LIST
					</strong>
				</div>
			</a>
		</div>
		<form id="form" class="formulario panel-shadow background-white border-radius-5 padding-v-30 validar alt" role="form" method="post" action="">
			{!! csrf_field() !!}

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

			<div class="col-sm-12">
				<h3 class="full-width text-left border-bottom-2 padding-15 no-margin">Edit user</h3>
			</div>

			<div class="full-width margin-top-15"></div>
			<div class="col-sm-4">
				<div class="form-group alt">
					<label class="titulo">Name*</label>
			        <input type="text" name="name" class="txt required form-control" placeholder="" value="{{ $user->name }}"/>
				</div>
			</div>
			<div class="full-width margin-top-15"></div>
			<div class="col-sm-4">
				<div class="form-group alt">
					<label class="titulo">e-Mail (used to log in)*</label>
			        <input type="text" name="email" class="txt required form-control" placeholder="" value="{{ $user->email }}"/>
				</div>
			</div>
			<input type="hidden" name="type" value="1"/>
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
