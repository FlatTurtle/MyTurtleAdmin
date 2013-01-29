<div class="row">
	<div class="span12">
		<h2><?= lang('term.infoscreens') ?></h2>
		<div id='infoscreens'>
			<? foreach ($infoscreens as $infoscreen) { ?>
				<a href="<?= site_url($infoscreen->alias); ?>">
					<div class='infoscreen'>
						<div class='screen'>
							<div class='inside'>
								<div class='color-side' style='background-color:<?= $infoscreen->color; ?>'>
								</div>
								<div class="logo-holder">
									<div class='logo' style="background-image:url('<?= $infoscreen->logo; ?>?<?= rand(0, 999999) ?>');"></div>
								</div>
							</div>
						</div>
						<?= $infoscreen->title ?>
					</div>
				</a>
			<? } ?>
		</div>
	</div>
</div>