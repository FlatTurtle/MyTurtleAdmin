<div class="row">
	<div class="span12">
		<h2>Infoscreens</h2>
		<div id='infoscreens'>
			<? foreach ($infoscreens as $infoscreen) { ?>
				<div class='infoscreen'>
					<div class='screen'>
						<div class='inside'>
						</div>
					</div>
					<?= $infoscreen->title ?>
				</div>
			<? } ?>
		</div>
	</div>
</div>