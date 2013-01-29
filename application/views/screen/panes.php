<div class="adding_pane_modal modal hide fade">
  <div class="modal-body">
  	<i class='loading'></i> <?= lang('panes.adding') ?>
  </div>
</div>
<div class="deleting_pane_modal modal hide fade">
  <div class="modal-body">
  	<i class='loading'></i> <?= lang('panes.deleting') ?>
  </div>
</div>
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
		<?
		if(!empty($panes)){
		?>
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
								echo ucfirst($pane->template);
								// Show title, when a custom title was set
								if(strtolower($pane->title) != $pane->template){
									echo " (".$pane->title.")";
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
		<?
		}
		?>

		<?
			$array_available_panes = (array) $available_panes;
			if(!empty($array_available_panes)){
		?>
			<h4><?= lang('panes.available') ?></h4>
			<?
			// Show the other available panes
			foreach($available_panes as $pane => $pane_value){
			?>
				<div id="<?= $pane; ?>" class='pane available_pane'>
					<div class='holder'>
						<input id='add_pane_<?= $pane ?>' type='checkbox' class='add_pane'/>
						<?
							echo $pane_value->name;
							if(!empty($pane_value->description)){
								echo "<span class='note'>".$pane_value->description."</span>";
							}
						?>
					</div>
				</div>
			<? } ?>
			<span class='note'><?= lang('panes.click_to_enable') ?></span>
		<? } ?>
	</div>
	<div class='pane-holder span9'>

		<h4><?= lang('panes.screen_title') ?></h4>
		<div class='pane-area'>
			<? if(!empty($current_pane)){ ?>
				<div class='pane-options'>
					<form action='<?= site_url($infoscreen->alias.'/right/save/'.$current_pane->id); ?>' class="form-horizontal" method='post'>
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
								<input type='submit' name='save' class="btn pane_save" value="<?= lang('term.save') ?>"/>
								<a id='delete_pane_<?= $current_pane->id ?>' href='#' class="btn btn-danger delete_pane" data-confirm='<?= lang('panes.disable_note') ?>'><?= lang('term.disable') ?></a>
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
			}
			?>
		</div>
	</div>
</div>