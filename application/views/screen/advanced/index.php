<?php
    $admin = false;
    if($this->session->userdata('rights') == 100){
        $admin = true;
    }
?>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/spectrum-min.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/spectrum.css" type="text/css" />
<div class="row">
    <div class="span2">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="active"><a href="#general" data-toggle="tab" aria-controls="general"><?= lang('settings_general') ?></a></li>
            <li role="presentation"><a href="#power" data-toggle="tab" aria-controls="power"><?= lang('settings_power') ?></a></li>
        </ul>
    </div>
    <div class="span8 tab-content">

        <!-- Start General tab -->
        <div role="tabpanel" class="tab-pane active" id="general">
            <form class="form-horizontal center" action="<?= site_url($infoscreen->alias . '/settings/update'); ?>" method="post" enctype="multipart/form-data">
                <div class="control-group<?= (!empty($errors['title'])) ? ' error' : ''; ?>">
                    <label class="control-label" for="inputTitle"><?= lang('term_title') ?></label>
                    <div class="controls">
                        <input type="text" id="inputTitle" name="title" placeholder="<?= lang('term_title') ?>" value="<?= $infoscreen->title; ?>" class="input-block-level"
                            <?php if(!$admin) echo "disabled='disabled'" ?>
                        >
                    </div>
                </div>
                <div class="control-group<?= (!empty($errors['location'])) ? ' error' : ''; ?>">
                    <label class="control-label" for="inputLocation"><?= lang('term_address') ?></label>
                    <div class="controls">
                        <input type="text" id="inputLocation" name="location" placeholder="<?= lang('screen_address_alt') ?>" value="<?= $infoscreen->location; ?>" class="input-block-level">
                        <span class='note'><?= ($infoscreen->latitude)? lang('screen_geographic_coordinates').': '.$infoscreen->latitude.', '.$infoscreen->longitude:lang('error_resolve_address'); ?></span>
                    </div>
                </div>
                <div class="control-group<?= (!empty($errors['color'])) ? ' error' : ''; ?>">
                    <label class="control-label" for="inputColor"><?= lang('term_color') ?></label>
                    <div class="controls">
                        <div class="input-prepend input-append">
                            <input type="text" id="inputColor" name="color" placeholder="#<?= strtolower(lang('term_color')) ?>" class="input-small" value="<?= $infoscreen->color; ?>" maxlength="7">
                        </div>
                    </div>
                </div>

                <div class="control-group <?= (!empty($file_error)) ? ' error' : ''; ?>">
                    <label class="control-label" for="inputLogo"><?= lang('term_logo') ?></label>
                    <div class="controls">
                        <input type="file" id="inputLogo" name="logo" class="hide better-file-upload"/>
                        <div class="input-append">
                           <input id="inputLogoVal" class="input-large file-value" type="text">
                           <a class="btn file-button"><?= lang('term_browse') ?></a>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputHostname"><?= lang('term_hostname') ?></label>
                    <div class="controls">
                        <input type="text" id="inputHostname" name="hostname" class="" value="<?= $infoscreen->hostname; ?>"
                            <?php if(!$admin) echo "disabled='disabled'" ?>
                        >
                    </div>
                </div>

                <?php if($admin || $infoscreen->pincode != ""){ ?>
                    <div class="control-group">
                        <label class="control-label" for="inputPin"><?= lang('screen_pin_for_tablet') ?></label>
                        <div class="controls">
                            <input type="text" id="inputPin" name="pincode" class="" value="<?= $infoscreen->pincode; ?>"
                                <?php if(!$admin) echo "disabled='disabled'" ?>
                                    >
                        </div>
                    </div>
                <?php } ?>

                <div class="control-group">
                    <label class="control-label" for="wifi"><?= lang('term_flatturtle_wifi')?></label>
                    <div class="controls">
                        <? if($admin){ ?>
                            <select id="wifi" name="wifi">
                                <option value="none" <?= $infoscreen->wifi == "none" ? ' selected="selected"' : '';?>><?= lang('term_no_wifi') ?></option>
                                <option value="auki" <?= $infoscreen->wifi == "auki" ? ' selected="selected"' : '';?>><?= lang('term_wifi_auki') ?></option>
                                <option value="normal" <?= $infoscreen->wifi == "normal" ? ' selected="selected"' : '';?>><?= lang('term_wifi_normal') ?></option>
                            </select>
                        <? } else { ?>
                            <? if($infoscreen->wifi != "none"){ ?>
                                <p><?= lang('term_wifi_enabled') ?></p>
                            <? }else{ ?>
                                <p><?= lang('term_wifi_disabled') ?></p>
                            <? } ?>
                        <? } ?>
                    </div>
                </div>
                <?php if($admin){ ?>
                    <div class="control-group">
                        <label class="control-label" for="allow_whitelabel"><?=lang('term_whitelabel');?></label>
                        <div class="controls">
                            <input type="checkbox" value="1" <?= $infoscreen->allow_whitelabel == 0 ? '' : ' checked="checked"';?> id="allow_whitelabel" name="allow_whitelabel">
                        </div>
                    </div>
                <?php } ?>
                <?php if($infoscreen->allow_whitelabel || $admin) {?>
                    <div class="control-group">
                        <label class="control-label" for="allow_whitelabel"><?=lang('term_hide_logo');?></label>
                        <div class="controls">
                            <input type="checkbox" value="1" <?= $infoscreen->hide_ft_logo == 0 ? '' : ' checked="checked"';?> id="hide_ft_logo" name="hide_ft_logo">
                        </div>
                    </div>
                <?php } ?>

                <?php if($admin){ ?>
                <div class="control-group">
                    <label class="control-label" for="disable_left"><?=lang('term_disable_left');?></label>
                    <div class="controls">
                        <input type="checkbox" value="1" <?= $infoscreen->disable_left == 0 ? '' : ' checked="checked"';?> id="disable_left" name="disable_left">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="disable_right"><?=lang('term_disable_right');?></label>
                    <div class="controls">
                        <input type="checkbox" value="1" <?= $infoscreen->disable_right == 0 ? '' : ' checked="checked"';?> id="disable_right" name="disable_right">
                    </div>
                </div>
                <? } ?>

                <div class="control-group">
                    <div class="controls">
                        <? if (!empty($all_errors)) { ?>
                            <div class="alert alert-error">
                                <?= $all_errors; ?>
                            </div>
                            <button type="submit" class="btn"><?= lang('term_retry') ?></button>
                            <a href="<?= site_url($infoscreen->alias. "/settings") ?>" class="btn"><?= lang('term_cancel') ?></a>
                        <? } else { ?>
                            <button type="submit" class="btn"><?= lang('term_save') ?></button>
                        <? } ?>
                    </div>
                </div>
            </form>
        </div>
        <!-- End general tab -->

        <!-- Start power settings tab -->
        <div role="tabpanel" class="tab-pane" id="power">
            <form class="form-horizontal center" action="<?= site_url($infoscreen->alias . '/settings/power'); ?>" method="post" enctype="multipart/form-data">
                <h4><?= lang('title_weekly_schedule') ?></h4>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?= lang('table_head_day') ?></th>
                            <th><?= lang('table_head_enabled') ?></th>
                            <th><?= lang('table_head_time_on') ?></th>
                            <th><?= lang('table_head_time_off') ?></th>
                        </tr>    
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= lang('term_monday') ?></td>
                            <td><input type="checkbox"/></td>
                            <td><input type="text" class="time" id="monday.on" placeholder="00:00"></td>
                            <td><input type="text" class="time" id="monday.off" placeholder="00:00"></td>
                        </tr>
                        <tr>
                            <td><?= lang('term_tuesday') ?></td>
                            <td><input type="checkbox"/></td>
                            <td><input type="text" class="time" id="tuesday.on" placeholder="00:00"></td>
                            <td><input type="text" class="time" id="tuesday.off" placeholder="00:00"></td>
                        </tr>
                        <tr>
                            <td><?= lang('term_wednesday') ?></td>
                            <td><input type="checkbox"/></td>
                            <td><input type="text" class="time" id="wednesday.on" placeholder="00:00"></td>
                            <td><input type="text" class="time" id="wednesday.off" placeholder="00:00"></td>
                        </tr>
                        <tr>
                            <td><?= lang('term_thursday') ?></td>
                            <td><input type="checkbox"/></td>
                            <td><input type="text" class="time" id="thursday.on" placeholder="00:00"></td>
                            <td><input type="text" class="time" id="thursday.off" placeholder="00:00"></td>
                        </tr>
                        <tr>
                            <td><?= lang('term_friday') ?></td>
                            <td><input type="checkbox"/></td>
                            <td><input type="text" class="time" id="friday.on" placeholder="00:00"></td>
                            <td><input type="text" class="time" id="friday.off" placeholder="00:00"></td>
                        </tr>
                        <tr>
                            <td><?= lang('term_saturday') ?></td>
                            <td><input type="checkbox"/></td>
                            <td><input type="text" class="time" id="saturday.on" placeholder="00:00"></td>
                            <td><input type="text" class="time" id="saturday.off" placeholder="00:00"></td>
                        </tr>
                        <tr>
                            <td><?= lang('term_sunday') ?></td>
                            <td><input type="checkbox"/></td>
                            <td><input type="text" class="time" id="sunday.on" placeholder="00:00"></td>
                            <td><input type="text" class="time" id="sunday.off" placeholder="00:00"></td>
                        </tr>
                    </tbody>    
                </table>

                <h4><?= lang('title_special_days') ?>&nbsp<button class="btn" id="add-special-day"><?= lang('button_add_days') ?></button></h4>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th><?= lang('table_head_date') ?></th>
                            <th><?= lang('table_head_enabled') ?></th>
                            <th><?= lang('table_head_time_on') ?></th>
                            <th><?= lang('table_head_time_off') ?></th>
                        </tr>
                    </thead>
                    <tbody id="special-days-content">
                        
                    </tbody>
                </table>

                <button type="submit" class="btn"><?= lang('term_save') ?></button>
            </form>

        </div>
        <!-- End power settings tab -->
    

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        initPowerSettings();
    });
</script>