<div class='row'>
	<div class='span12'>
		<h2>
			<a href="<?= site_url('screen/' . $infoscreen->alias); ?>" class='blacklink'>
				<i class="icon-chevron-left"></i>&nbsp;&nbsp;<?= $infoscreen->title; ?>&nbsp;&gg;&nbsp;Left
			</a>
		</h2>
	</div>
</div>
<div class='row'>
	<div class='turtle-chooser span3'>
		<h4>Available turtles</h4>
		<? foreach($turtle_types as $turtle_type){ ?>
			<div id="<?=$turtle_type->type ?>" class='turtle draggable'>
				<?= $turtle_type->name; ?>
			</div>
		<? } ?>
		<span class='note'>Drag turtles to the screen</span>
	</div>
	<div class='turtle-holder span9'>
		<h4>Left side of the screen</h4>
		<nav id='pane-selector'>
			<ul>
			<? foreach($panes as $pane){ ?>
				<li>&bull;</li>
			<? } ?>
			</ul>
		</nav>
		<?
			$first = true;
			foreach($panes as $pane){ ?>
		<div id='pane_<?= $pane->id ?>' class="turtle-area droppable sortable <? echo ($first)? '':'hide'; ?>">
			<? foreach($turtle_instances as $turtle){
				if($pane->id == $turtle->pane_id){
					echo $turtle->content;
				}
				?>
			<? } ?>
		</div>
		<? 		$first = false;
			} ?>
		<span class='note'>Drag turtles to sort</span>
	</div>
</div>