<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>@yield('title') - {{ env('APP_NAME') }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
	</head>

	<body style="background-color:#fff; font-family:Roboto,sans-serif">

		<table bgcolor="#e0e0e0" width="640" align="center" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td height="20"></td>
			</tr>

			<tr>
				<td width="10" rowspan="2"></td>
				<td height="0" align="center" style="border-radius: 3px 3px 0 0; border-bottom: 1px solid #ccc">
					<table width="100%">
						<tbody>
							<tr>
								<td align="left" style="padding:10px 5px; text-align:center; font-size:36px; color:#777">
									<img src="{{ $message->embed(public_path() . env('APP_URL_PREFIX').'img/logo.png') }}" width="150px" style="max-width:150px"/>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td width="10" rowspan="2"></td>
			</tr>

			<!--
			<tr>
				<td width="10" rowspan="2"></td>
				<td height="0" align="center" style="border-radius: 3px 3px 0 0;">
					<table width="100%">
						<tbody>
							<tr>
								<td align="left" style="padding:10px 5px; text-align:left; font-size:36px; color:#777">
									@yield('title')
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td width="10" rowspan="2"></td>
			</tr>
			-->

			<tr>
				<td align="center">
					<table width="100%" style="font-size:14px; line-height:20px; color:#333">
						<tbody>
							<tr>
								<td align="center" style="line-height:1; padding: 5px 24px 24px 24px">
									@yield('body')
									
									<br><br>

									We look forward to seeing you there, <br>
									Justin.
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<table width="100%" style="font-size:12px; color:#888; line-height:17px">
						<tbody>
							<tr>
								<td></td>
								<td style="text-align:center;border-top: 1px solid #ccc">
									<p>{{ env('APP_CORP_ADDRESS') }}. <br/></p>
									<p>© {!! date('Y') !!} {{ env('APP_NAME') }}.</p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td></td>
			</tr>
			</tbody>
		</table>
	</body>
</html>
