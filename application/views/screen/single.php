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
				<div class="btn-group">
					<button class="btn"><i class="icon-comment icon-large"></i></button>
					<button class="btn"><i class="icon-time icon-large"></i></button>
					<button class="btn"><i class="icon-eye-open icon-large"></i></button>
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
					
					<? if(!empty($logo)){ ?>
					<div class='logo' style="background-image:url('<?= base_url().$logo; ?>?<?= rand(0, 999999) ?>');"></div>
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
							<?= (!empty($file_error))? '<br/>':''; ?>
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
