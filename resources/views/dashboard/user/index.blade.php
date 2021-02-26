@extends('layouts.adm')
@section('menu_user', 'active')
@section('page_title', 'Users')

@section('content')

<div class="full-width list">
	<div class="col-sm-12 xs-no-margin xs-no-padding">
		<div class="col-sm-12 xs-no-margin xs-no-padding">

            <form id="searchform" class="formulario validar alt" role="form" method="post" action="">
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
						<div class="col-sm-11">
							<div class="form-group alt">
								<label class="titulo">Name</label>
								<input type="text" name="name" class="txt focus form-control" placeholder="" value="{{ $filter['name'] or '' }}"/>
							</div>
						</div>
						<input type="hidden" name="type" value="0"/>
						<input type="hidden" name="order" value="0"/>
						<!--
						<div class="col-sm-2">
							<div class="form-group alt">
								<label class="titulo">Tipo</label>
								<select name="type" class="full-width no-margin no-text-indent txt">
									<option value="0" {{ ($filter['type'] == 0 || !$filter['type']) ? 'selected' : '' }}>Todos</option>
									<option value="1" {{ $filter['type'] == 1 ? 'selected' : '' }}>Admin</option>
									<option value="2" {{ $filter['type'] == 2 ? 'selected' : '' }}>Comun</option>
								</select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group alt">
								<label class="titulo">Ordenar</label>
								<select name="order" class="full-width no-margin no-text-indent txt">
									<option value="1" {{ ($filter['order'] == 1 || !$filter['order']) ? 'selected' : '' }}>Nome</option>
									<option value="2" {{ $filter['order'] == 2 ? 'selected' : '' }}>Data de cadastro</option>
								</select>
							</div>
						</div>
						-->
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
								<strong>Users</strong>
							</h3>
						</div>
						<div class="col-sm-6 col-xs-6 text-right xs-text-center">
                            <div class="btn btn-transparent btn-transparent-primary showsearch">
                                <i class="material-icons pull-right">search</i>
                            </div>
							<a href="{{ env('APP_URL_PREFIX') }}dashboard/user/create">
								<div class="btn btn-primary">CREATE</div>
							</a>
						</div>
					</div>
				</div>
				@if($users->count() == 0)
				<div class="col-sm-6 col-sm-offset-3">
					<div id="center-alert" class="full-width text-center" class="content">
						<i class="fas fa-flushed ico"></i>
						<div class="full-width title-medium">SEM USUÁRIOS...</div>
					</div>
				</div>
				@else
				<div class="full-width panel-shadow background-white border-radius-5">
					<div class="col-sm-12">
						<div class="full-width line">
							<div class="col-sm-4 xs-text-center title">
								<span class="full-width sub">Name</span>
							</div>
							<div class="col-sm-5 xs-hidden">
								<span class="full-width sub">Email</span>
							</div>
							<div class="col-sm-3 xs-hidden">
								<span class="full-width sub">Actions</span>
							</div>
						</div>
						@foreach($users as $key => $user)
						<div class="full-width line">
							<div class="col-sm-4 xs-text-center title">
								<strong class="full-width main">{{ $user->name }}</strong>
							</div>
							<div class="col-sm-5 xs-hidden">
								<strong class="full-width main">{{ $user->email }}</strong>
								<!--
								<span class="full-width sub">{{ $user->email }}</span>
								<span class="full-width main">Usuário <strong>{{ $user->type == 1 ? 'Admin' : 'Produtor' }}</strong></span>
								<span class="full-width sub">{{ isset($user->phone) ? $user->phone : '' }}</span>
								-->
							</div>
							<div class="col-sm-3 text-left xs-text-center options">
								<div class="display-inline-hover">
									<!--
									<a href="{{ env('APP_URL_PREFIX') }}dashboard/user/{{ $user->id }}">
										<button class="btn btn-transparent btn-min">DETAILS</button>
									</a>
									-->
									<a href="{{ env('APP_URL_PREFIX') }}dashboard/user/edit/{{ $user->id }}">
										<button class="btn btn-transparent btn-min">EDIT</button>
									</a>
									<a href="{{ env('APP_URL_PREFIX') }}dashboard/user/status/delete/{{ $user->id }}" class="confirmdelete">
										<button class="btn btn-transparent btn-transparent-danger btn-min">DELETE</button>
									</a>
								</div>
							</div>
						</div>
						@endforeach
						{!! $users->render() !!}
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection
