@extends('layouts.adm')
@section('menu_user', 'active')
@section('page_title', 'Logs de usuario')

@section('content')

<div class="container">
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
	<div id="logs">
		<div class="full-width">
			<div class="col-sm-12">
				<div class="alert alert-info alert-dismissable dica">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					Informação de acesso ao sistema. Hora que este usuário entrou e hora que saiu do sistema. <br>
					Usuário: <strong>{{ $user->name }} - {{ $user->email }}</strong> <br>
					Total de acessos: <strong>{{ $logs_total }}</strong>
					{{$logs}}
				</div>
				<div class="full-width sys-table table-responsive">
					<div class="full-width">
						<div class="content">
							<table class="no-border">
								<thead class="no-border">
									<tr>
							            <th class="coltit">Data de entrada</th>
							            <th class="coltit">Data de sa&iacute;da</th>
							            <th class="coltit">IP</th>
									</tr>
								</thead>
								<tbody class="no-border-x no-border-y">
									@foreach($logs as $key => $log)
								        <tr>
								            <td class="coltxt">
								            	{{ $log->date_in->format('d/m/Y H:i:s') }}
								            </td>
								            <td class="coltxt">
								            	@if($log->date_out > '0000/00/00 00:00:00')
								            		{{ $log->date_out->format('d/m/Y H:i:s') }}	
								            	@else

								            	@endif
								            </td>
								            <td class="coltxt">
								            	{{ $log->ip }}
								            </td>
								        </tr>
							        @endforeach
							    </tbody>
							</table>
							{!! $logs->render() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection