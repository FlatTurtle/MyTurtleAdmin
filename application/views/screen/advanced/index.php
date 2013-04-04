<?php
    $admin = false;
    if($this->session->userdata('rights') == 1){
        $admin = true;
    }
?>
<div class="row">
    <div class="span12">
        <form class="form-horizontal center" action="<?= site_url($infoscreen->alias . '/advanced/update'); ?>" method="post" enctype="multipart/form-data">
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

            <?php if($this->session->userdata('rights') == 1){ ?>
            <div class="control-group">
                <div class="controls">
                    <? if (!empty($all_errors)) { ?>
                        <div class="alert alert-error">
                            <?= $all_errors; ?>
                        </div>
                        <button type="submit" class="btn"><?= lang('term.retry') ?></button>
                        <a href="<?= site_url($infoscreen->alias. "/advanced") ?>" class="btn"><?= lang('term.cancel') ?></a>
                    <? } else { ?>
                        <button type="submit" class="btn"><?= lang('term.save') ?></button>
                    <? } ?>
                </div>
            </div>
            <? } ?>
        </form>
    </div>
</div>