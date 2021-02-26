@extends('layouts.adm')
@section('menu_user', 'active')
@section('page_title', 'Change password')

@section('content')

<div class="full-width">
	<div class="col-sm-4 col-sm-offset-4 xs-no-padding xs-no-margin">
		<form id="form" class="formulario panel-shadow background-white border-radius-5 padding-v-30 margin-top-30 validar alt" role="form" method="post" action="">
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
				<h3 class="full-width text-center border-bottom-2 padding-15 no-margin">Change password</h3>
			</div>

			<div class="col-sm-12">
				<div class="form-group alt">
					<label class="titulo">Current password</label>
			        <input type="password" autofocus name="today" class="txt required form-control" placeholder="******"/>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group alt">
					<label class="titulo">New password</label>
			        <input type="password" name="new" class="txt passval required form-control" placeholder="******"/>
			        <p class="help-block ajuda"><em>TIP: to have a secure password use more than 6 characters. At least one number and one letter!</em></p>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group alt">
					<label class="titulo">Confirm new password</label>
			        <input type="password" name="repeat" class="txt passval required form-control" placeholder="******"/>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="full-width margin-bottom-15 margin-top-15">
					<button type="submit" class="full-width btn btn-danger showloading">SAVE</button>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection