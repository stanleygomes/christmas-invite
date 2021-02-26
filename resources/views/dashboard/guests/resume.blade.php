<div class="full-width panel-shadow background-white border-radius-5 padding-15 panel">
	<div class="col-sm-3">
		<div class="full-width border-right">
			<div class="row">
				<div class="col-sm-4 text-center">
					<i class="fa fa-user color-black icon"></i>
				</div>
				<div class="col-sm-8">
					<span class="percentage">{{ $guestsCount }}</span>
					<div class="description"><strong>Total guests</strong></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="full-width border-right">
			<div class="row">
				<div class="col-sm-4 text-center">
					<i class="fa fa-paper-plane color-primary icon"></i>
				</div>
				<div class="col-sm-8">
					<span class="number">{{ $statusCount['invite_sent'] }}</span><strong class="percentage">/{{ $statusCount['invite_sent_percentage'] }}%</strong>
					<div class="description"><strong>Invited</strong></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="full-width border-right">
			<div class="row">
				<div class="col-sm-3 text-center">
					<i class="fa fa-mouse-pointer color-warning icon"></i>
				</div>
				<div class="col-sm-9">
					<span class="number">{{ $statusCount['open_link'] }}</span><strong class="percentage">/{{ $statusCount['open_link_percentage'] }}%</strong>
					<div class="description"><strong>Opened the link</strong></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="full-width">
			<div class="row">
				<div class="col-sm-3 text-center">
					<i class="fa fa-check color-success icon"></i>
				</div>
				<div class="col-sm-9">
					<span class="number">{{ $statusCount['confirmed'] }}</span><strong class="percentage">/{{ $statusCount['confirmed_percentage'] }}%</strong>
					<div class="description"><strong>Confirmed</strong></div>
				</div>
			</div>
		</div>
	</div>
</div>
