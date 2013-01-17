<div class='row'>
	<div class='span12'>
		<h2>
			<a href="<?= site_url($infoscreen->alias); ?>" class='blacklink'>
				<i class="icon-chevron-left"></i>&nbsp;&nbsp;<?= $infoscreen->title; ?>&nbsp;&gg;&nbsp;<?= lang('term.left') ?>
			</a>
		</h2>
	</div>
</div>
<div class='row'>
	<div class='turtle-chooser span3'>
		<h4><?= lang('turtles.available') ?></h4>
		<? foreach($turtle_types as $turtle_type){ ?>
		<div id="<?=$turtle_type->type ?>" class='turtle draggable'>
			<?= $turtle_type->name; ?>
		</div>
		<? } ?>
		<span class='note'><?= lang('turtles.drag_to_screen') ?></span>
	</div>
	<div class='turtle-holder span9'>
		<h4><?= lang('turtles.screen_title') ?></h4>
		<nav id='pane-selector'>
			<ul>
				<?
				if(count($panes) > 1){
					$active_class = "class='active'";
					foreach($panes as $pane){
						echo "<li id='pane-selector_". $pane->id ."' ". $active_class .">&bull;</li>";
						$active_class = "";
					}
				}
				?>
			</ul>
		</nav>
		<?
		$extra_class = "";
		foreach($panes as $pane){
			echo "<div id='pane_".$pane->id."' class='turtle-area droppable sortable'>";
			foreach($turtle_instances as $turtle){
				if($pane->id == $turtle->pane_id){
					echo $turtle->content;
				}
			}
			echo "</div>";
			$extra_class = "hide";
		}
		?>
		<span class='note'><?= lang('turtles.drag_to_sort') ?></span>
	</div>
</div>