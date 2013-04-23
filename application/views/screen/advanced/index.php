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
                <label class="control-label" for="inputTitle"><?= lang('term.title') ?></label>
                <div class="controls">
                    <input type="text" id="inputTitle" name="title" placeholder="<?= lang('term.title') ?>" value="<?= $infoscreen->title; ?>" class="input-block-level"
                        <?php if(!$admin) echo "disabled='disabled'" ?>
                    >
                </div>
            </div>
            <div class="control-group<?= (!empty($errors['location'])) ? ' error' : ''; ?>">
                <label class="control-label" for="inputLocation"><?= lang('term.address') ?></label>
                <div class="controls">
                    <input type="text" id="inputLocation" name="location" placeholder="<?= lang('screen.address_alt') ?>" value="<?= $infoscreen->location; ?>" class="input-block-level">
                    <span class='note'><?= ($infoscreen->latitude)? lang('screen.geographic_coordinates').': '.$infoscreen->latitude.', '.$infoscreen->longitude:lang('error.resolve_address'); ?></span>
                </div>
            </div>
            <div class="control-group<?= (!empty($errors['color'])) ? ' error' : ''; ?>">
                <label class="control-label" for="inputColor"><?= lang('term.color') ?></label>
                <div class="controls">
                    <div class="input-prepend input-append">
                        <input type="text" id="inputColor" name="color" placeholder="#<?= strtolower(lang('term.color')) ?>" class="input-small" value="<?= $infoscreen->color; ?>" maxlength="7">
                    </div>
                </div>
            </div>

            <div class="control-group <?= (!empty($file_error)) ? ' error' : ''; ?>">
                <label class="control-label" for="inputLogo"><?= lang('term.logo') ?></label>
                <div class="controls">
                    <input type="file" id="inputLogo" name="logo" class="hide better-file-upload"/>
                    <div class="input-append">
                       <input id="inputLogoVal" class="input-large file-value" type="text">
                       <a class="btn file-button"><?= lang('term.browse') ?></a>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputHostname"><?= lang('term.hostname') ?></label>
                <div class="controls">
                    <input type="text" id="inputHostname" name="hostname" class="" value="<?= $infoscreen->hostname; ?>"
                        <?php if(!$admin) echo "disabled='disabled'" ?>
                    >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPin"><?= lang('screen.pin_for_tablet') ?></label>
                <div class="controls">
                    <input type="text" id="inputPin" name="pincode" class="" value="<?= $infoscreen->pincode; ?>"
                        <?php if(!$admin) echo "disabled='disabled'" ?>
                    >
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <? if (!empty($all_errors)) { ?>
                        <div class="alert alert-error">
                            <?= $all_errors; ?>
                        </div>
                        <button type="submit" class="btn"><?= lang('term.retry') ?></button>
                        <a href="<?= site_url($infoscreen->alias. "/settings") ?>" class="btn"><?= lang('term.cancel') ?></a>
                    <? } else { ?>
                        <button type="submit" class="btn"><?= lang('term.save') ?></button>
                    <? } ?>
                </div>
            </div>
        </form>
    </div>
</div>