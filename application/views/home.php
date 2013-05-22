<div class="row">
    <div class="span12" data-step="2" data-intro="<?php echo lang('help_select_screen'); ?>">
        <div class='infoscreens'>
            <div class="alert alert-info alert-block search-message hide">
                <?php echo lang('warn_no_screens_found') ?>
            </div>
            <?
                $reached_inactive = false;
                foreach ($infoscreens as $infoscreen) {
                    // Check for inactive screens
                    if(!$reached_inactive && empty($infoscreen->hostname)){
                        $reached_inactive = true;
                        echo '
                                        <a href="#" class="more">
                                            <span>'.lang('term_more').'</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span12">
                                    <div class="infoscreens inactive hide">';
                    }


                    $extra_css_class = "";
                    if(!$infoscreen->power)
                        $extra_css_class = "disabled"
            ?>
                <a href="<?= site_url($infoscreen->alias); ?>" data-title="<?= strtolower($infoscreen->title) ?>" class="screen-link">
                    <div class='infoscreen <?= $extra_css_class ?>'>
                        <div class='screen'>
                            <?php
                                if($infoscreen->power){
                                    if($infoscreen->shot){
                            ?>
                                    <img src="data:image/jpg;base64,<?= $infoscreen->shot ?>" />
                            <?php
                                    }else{
                            ?>
                                    <div class='inside'>
                                        <div class='color-side' style='background-color:<?= $infoscreen->color; ?>'>
                                        </div>
                                        <div class="logo-holder">
                                            <div class='logo' style="background-image:url('<?= $infoscreen->logo; ?>?<?= rand(0, 999999) ?>');"></div>
                                        </div>
                                    </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <?= $infoscreen->title ?>
                    </div>
                </a>
            <? } ?>
        </div>
    </div>
</div>