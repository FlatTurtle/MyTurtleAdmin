<div id="messageModal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Send a message</h3>
	</div>
	<div class="modal-body">
		<input id='the_message' class="input-block-level"/><br/>
		<span class='note'>The message is displayed on the screen for a small time.</span>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
		<a href="#" id="btnSendMessage" class="btn btn-primary">Send</a>
	</div>
</div>

<div class='row'>
	<div class='span12'>
		<h2>
			<a href="<?= site_url('/'); ?>" class='blacklink'>
				<i class="icon-chevron-left"></i>&nbsp;&nbsp;<?= $infoscreen->title; ?>
			</a>
		</h2>

		<div class="single-infoscreen">
			<div class="dummy"></div>
			<div class="screen">
				<?
					$clock_class = 'active';
					if(!$state_clock){
						$clock_class = '';
					}
					$screen_class = 'icon-eye-open active';
					if(!$state_screen){
						$screen_class = 'icon-eye-close';
					}
				?>

				<div class="btn-group">
					<a href='#messageModal' role='button' class="btn" data-toggle="modal" title="Display a message on the screen">
						<i class="icon-comment icon-large"></i>
					</a>
					<a href='#' id="btnToggleClock" role='button' class="btn" title="Toggle the clock">
						<i class="icon-time icon-large <?= $clock_class ?>"></i>
					</a>
					<a href='#' id="btnToggleScreen" role='button' class="btn"  title="Switch the screen on and off">
						<i class="<?= $screen_class ?> icon-large"></i>
					</a>
				</div>

				<div class='inner'>
					<a href="<?= site_url('screen/' . $infoscreen->alias . '/left') ?>">
						<div class='left-side'>

						</div>
					</a>
					<a href="<?= site_url('screen/' . $infoscreen->alias . '/right') ?>">
						<div class='right-side' style='background-color:<?= $infoscreen->color; ?>;'>

						</div>
					</a>

					<? if (!empty($logo)) { ?>
						<div class="logo-holder">
							<div class='logo' style="background-image:url('<?= base_url() . $logo; ?>?<?= rand(0, 999999) ?>');"></div>
						</div>
					<? } ?>
				</div>
			</div>
		</div>

		<form class="form-horizontal center" action="<?= site_url('screen/' . $infoscreen->alias . '/update'); ?>" method="post" enctype="multipart/form-data">

			<ul class="pager">
				<li class="previous">
					<a href="<?= site_url('screen/' . $infoscreen->alias . '/left') ?>">&larr; Left side</a>
				</li>
				<li class="next">
					<a href="<?= site_url('screen/' . $infoscreen->alias . '/right') ?>">Right side &rarr;</a>
				</li>
			</ul>

			<div class="control-group<?= (!empty($errors['title'])) ? ' error' : ''; ?>">
				<label class="control-label" for="inputTitle">Title</label>
				<div class="controls">
					<input type="text" id="inputTitle" name="title" placeholder="Title" value="<?= $infoscreen->title; ?>" class="input-block-level">
				</div>
			</div>
			<div class="control-group<?= (!empty($errors['location'])) ? ' error' : ''; ?>">
				<label class="control-label" for="inputLocation">Address</label>
				<div class="controls">
					<input type="text" id="inputLocation" name="location" placeholder="Address your building (Ex: Veldstraat 10, Gent)" value="<?= $infoscreen->location; ?>" class="input-block-level">
					<span class='note'><?= ($infoscreen->latitude)? 'Geographic coordinates: '.$infoscreen->latitude.', '.$infoscreen->longitude:''; ?></span>
				</div>
			</div>
			<div class="control-group<?= (!empty($errors['color'])) ? ' error' : ''; ?>">
				<label class="control-label" for="inputColor">Color</label>
				<div class="controls">
					<div class="input-prepend input-append">
						<span class="add-on" style="background-color:<?= $infoscreen->color; ?>;"></span>
						<input type="text" id="inputColor" name="color" placeholder="#color" class="input-small" value="<?= $infoscreen->color; ?>" maxlength="7">
					</div>
				</div>
			</div>
			<div class="control-group <?= (!empty($file_error)) ? ' error' : ''; ?>">
				<label class="control-label" for="inputLogo">Logo</label>
				<div class="controls">
					<input type="file" id="inputLogo" name="logo">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputHostname">Hostname</label>
				<div class="controls">
					<input type="text" id="inputHostname" placeholder="Hostname" class="" value="<?= $infoscreen->hostname; ?>" disabled>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<? if (!empty($all_errors) || !empty($file_error)) { ?>
						<div class="alert">
							<?= $file_error ?>
							<?= (!empty($file_error)) ? '<br/>' : ''; ?>
							<?= $all_errors; ?>
						</div>
						<button type="submit" class="btn">Retry</button>
						<a href="<?= site_url('screen/' . $infoscreen->alias) ?>" class="btn">Cancel</a>
					<? } else { ?>
						<button type="submit" class="btn">Save</button>
					<? } ?>
				</div>
			</div>
		</form>
	</div>
</div>
