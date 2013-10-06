<?php
    $admin = false;
    if($this->session->userdata('rights') == 100){
        $admin = true;
    }
?>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/spectrum-min.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/spectrum.css" type="text/css" />
<div class="row">
    <div class="span12">
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
            <div class="control-group">
                <label class="control-label" for="inputPin"><?= lang('screen_pin_for_tablet') ?></label>
                <div class="controls">
                    <input type="text" id="inputPin" name="pincode" class="" value="<?= $infoscreen->pincode; ?>"
                        <?php if(!$admin) echo "disabled='disabled'" ?>
                    >
                </div>
            </div>
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
</div>