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
	<div class='turtle-chooser span4'>
		<h4>Available turtles</h4>
		<? foreach($turtle_types as $turtle_type){ ?>
			<div class='turtle draggable'>
				<?= $turtle_type->name; ?>
			</div>
		<? } ?>
	</div>
	<div class='turtle-holder span8'>
		<h4>Left side of the screen</h4>
		<div class='turtle-area droppable'>
			<div class='drag-notice'>
				Drag your turtles here
			</div>
		</div>
	</div>
</div>