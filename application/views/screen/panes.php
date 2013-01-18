<div class='row'>
	<div class='span12'>
		<h2>
			<a id='config' href="<?= site_url($infoscreen->alias); ?>" class='blacklink' >
				<i class="icon-chevron-left"></i>&nbsp;&nbsp;<?= $infoscreen->title; ?>&nbsp;&gg;&nbsp;Right
			</a>
		</h2>
	</div>
</div>
<div class='row'>
	<div class='pane-chooser span3'>
		<h4><?= lang('panes.enabled') ?></h4>
		<?
		// Show all enabled panes
		foreach($panes as $pane){
			$extra_class = "";
			if($pane->id == $current_pane->id)	$extra_class = "active";
		?>
			<div id="pane_<?= $pane->id; ?>" class='pane draggable <?= $extra_class ?>'>
				<a href='<?= site_url($infoscreen->alias.'/right/'.$pane->template.'/'.$pane->id. "#config"); ?>'>
					<div class='holder'>
					<?
						echo $pane->title;

						// Show template when title is different
						if(strtolower($pane->title) != $pane->template){
							echo " (".$pane->template.")";
						}

						if(!empty($pane->description)){
							echo "<span class='note'>".$pane->description."</span>";
						}
					?>
					</div>
				</a>
			</div>
		<?
		}
		?>
		<span class='note'><?= lang('panes.drag_to_sort') ?></span>

		<h4><?= lang('panes.available') ?></h4>
		<?
		// Show the other available pans
		foreach($available_panes as $pane => $pane_value){
		?>
			<div id="<?= $pane; ?>" class='pane'>
				<div class='holder'>
					<input type='checkbox' />
					<?
						echo $pane;
						if(!empty($pane_value->description)){
							echo "<span class='note'>".$pane_value->description."</span>";
						}
					?>
				</div>
			</div>
		<? } ?>
		<span class='note'><?= lang('panes.click_to_enable') ?></span>
	</div>
	<div class='pane-holder span9'>
		<h4><?= lang('panes.screen_title') ?></h4>
		<div class='pane-area'>
			<div class='pane-options'>
				<form class="form-horizontal" onsubmit="return false;">
					<div class="control-group">
					    <div class="controls">
							<h4><?= lang('panes.general_options') ?></h4>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="title"><?= lang('term.title') ?></label>
					    <div class="controls">
							<input type="text" id="pane-title" name="title" class='input-large' value="<?= $current_pane->title ?>"/>
						</div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="duration"><?= lang('term.duration') ?></label>
					    <div class="controls">
							<select name="duration">
								<?= $duration_options ?>
							</select>
							&nbsp;<?= strtolower(lang('term.seconds')) ?>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<a href='#' class="btn pane_save"><?= lang('term.save') ?></a>
							<a href='#' class="btn btn-danger"><?= lang('term.disable') ?></a>
						</div>
					</div>
				</form>
			</div>
			<?
			// Show turtles for current pane
			foreach($turtles as $turtle){
				if($turtle->pane_id == $current_pane->id){
					echo $turtle->content;
				}
			}
			?>
		</div>
	</div>
</div>