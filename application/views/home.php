<div class="row">
    <div class="span12">
        <div id='infoscreens'>
            <?
                foreach ($infoscreens as $infoscreen) {
                    $extra_css_class = "";
                    if(!$infoscreen->power)
                        $extra_css_class = "disabled"
            ?>
                <a href="<?= site_url($infoscreen->alias); ?>">
                    <div class='infoscreen <?= $extra_css_class ?>'>
                        <div class='screen'>
                            <div class='inside'>
                                <div class='color-side' style='background-color:<?= $infoscreen->color; ?>'>
                                </div>
                                <div class="logo-holder">
                                    <div class='logo' style="background-image:url('<?= $infoscreen->logo; ?>?<?= rand(0, 999999) ?>');"></div>
                                </div>
                            </div>
                        </div>
                        <?= $infoscreen->title ?>
                    </div>
                </a>
            <? } ?>
        </div>
    </div>
</div>