<div class='row'>
	<div class='span12'>
		<h2>
			<a href="<?= site_url($infoscreen->alias); ?>" class='blacklink'>
				<i class="icon-chevron-left"></i>&nbsp;&nbsp;<?= $infoscreen->title; ?>&nbsp;&gg;&nbsp;Right
			</a>
		</h2>
	</div>
</div>
<div class='row'>
	<div class='pane-chooser span3'>
		<h4>Enabled panes</h4>
		<? foreach($panes as $pane){ ?>
		<div id="pane_<?= $pane->id; ?>" class='pane draggable'>
			<?
				echo $pane->title;
				if(!empty($pane->description)){
					echo "<span class='note'>".$pane->description."</span>";
				}
			?>
		</div>
		<? } ?>
		<span class='note'>Drag panes to sort</span>

		<h4>Available panes</h4>
		<? foreach($available_panes as $pane => $pane_value){ ?>
		<div id="<?= $pane; ?>" class='pane'>
			<input type='checkbox' />
			<?
				echo $pane;
				if(!empty($pane_value->description)){
					echo "<span class='note'>".$pane_value->description."</span>";
				}
			?>
		</div>
		<? } ?>
		<span class='note'>Click to enable panes</span>
	</div>
	<div class='pane-holder span9'>
		<h4>Right side of the screen</h4>
		<div class='pane-area'>

		</div>
	</div>
</div>