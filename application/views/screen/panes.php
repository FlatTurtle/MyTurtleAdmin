<div class="adding_pane_modal modal hide fade">
  <div class="modal-body">
    <i class='loading'></i> <?= lang('panes_adding') ?>
  </div>
</div>
<div class="deleting_pane_modal modal hide fade">
  <div class="modal-body">
    <i class='loading'></i> <?= lang('panes_deleting') ?>
  </div>
</div>
<div class='row'>
    <div class='pane-chooser sortable span3'>
        <? if(!$infoscreen->disable_right){ ?>

        <?
        if(!empty($panes)){
        ?>
        <h4><?= lang('panes_enabled') ?></h4>


            <div class="sortable" data-step="1" data-intro="<?php echo lang('help_panes_enabled'); ?>">
            <?
                // Show all enabled panes
                foreach($panes as $pane){
                    $extra_class = "";
                    if($pane->id == $current_pane->id)  $extra_class = "active";
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
            </div>
            <span class='note'><?= lang('panes_drag_to_sort') ?></span>
                <?
                }

                    $array_available_panes = (array) $available_panes;
                    if(!empty($array_available_panes)){
                ?>
            <div data-step="2" data-intro="<?php echo lang('help_panes_available'); ?>" data-position="top">
                    <h4><?= lang('panes_available') ?></h4>
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
                    <span class='note'><?= lang('panes_click_to_enable') ?></span>
                <? } ?>
            </div>
        <? }else{ ?>
            <p><?= lang('panes_right_side_disabled')?></p>
        <? } ?>
    </div>
    <div class='pane-holder span9'>

        <h4><?= lang('panes_screen_title') ?></h4>
        <div class='pane-area' data-step="3" data-intro="<?php echo lang('help_panes_area'); ?>" data-position="top">
            <? if(!empty($current_pane)){ ?>
                <div class='pane-options' data-step="4" data-intro="<?php echo lang('help_panes_general_options'); ?>" data-position="left">
                    <form action='<?= site_url($infoscreen->alias.'/right/save/'.$current_pane->id); ?>' class="form-horizontal" method='post'>
                        <div class="control-group">
                            <div class="controls">
                                <h4><?= lang('panes_general_options') ?></h4>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="title"><?= lang('term_title') ?></label>
                            <div class="controls">
                                <input type="text" id="pane-title" name="title" class='input-large' value="<?= $current_pane->title ?>"/>
                            </div>
                        </div>
                        <?
                        // Don't show duration option for video pane
                        if($current_pane->template != "video"){
                        ?>
                            <div class="control-group">
                                <label class="control-label" for="duration"><?= lang('term_duration') ?></label>
                                <div class="controls">
                                    <select name="duration">
                                        <?= $duration_options ?>
                                    </select>
                                    &nbsp;<?= strtolower(lang('term_seconds')) ?>
                                </div>
                            </div>
                        <?
                        }else{
                        ?>
                            <div class="control-group">
                                <label class="control-label" for="duration"><?= lang('term_duration') ?></label>
                                <div class="controls">
                                    <input type="text" id="duration" name="duration" class='input-medium' value="<?= $duration_options ?>"/>
                                </div>
                            </div>

                        <?
                        }
                        ?>
                        <div class="control-group">
                            <div class="controls">
                                <input type='submit' name='save' class="btn pane_save" value="<?= lang('term_save') ?>"/>
                                <a id='delete_pane_<?= $current_pane->id ?>' href='#' class="btn btn-danger delete_pane" data-confirm='<?= lang('panes_disable_note') ?>'><?= lang('term_disable') ?></a>
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
