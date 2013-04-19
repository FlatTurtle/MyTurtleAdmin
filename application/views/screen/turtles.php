<div class='row'>
    <div class='turtle-chooser span3' data-step="1" data-intro="<?php echo lang('help.turtles_available'); ?>">
        <h4><?= lang('turtles.available') ?></h4>
        <? foreach($turtle_types as $turtle_type){ ?>
        <div id="<?=$turtle_type->type ?>" class='turtle draggable'>
            <?= $turtle_type->name; ?>
        </div>
        <? } ?>
        <span class='note'><?= lang('turtles.drag_to_screen') ?></span>
    </div>
    <div class='turtle-holder span9' data-step="2" data-intro="<?php echo lang('help.turtles_area'); ?>" data-position="top">
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
            echo "<div id='pane_".$pane->id."' class='turtle-area droppable sortable ".$extra_class."'>";
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
<script type='text/javascript'>
    var from = new Object();
    from.lat = <?php echo $infoscreen->latitude ?>;
    from.lon = <?php echo $infoscreen->longitude ?>;
</script>