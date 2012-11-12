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
		<div class='turtle-area droppable sortable'>
			<? foreach($turtle_instances as $turtle){
				echo $turtle->content;
				?>
			<? } ?>
		</div>
		<span class='note'>Drag turtles to sort</span>
	</div>
</div>