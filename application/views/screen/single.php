<div id="messageModal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?= lang('screen_sent_message') ?></h3>
    </div>
    <div class="modal-body">
        <input id='the_message' class="input-block-level"/><br/>
        <span class='note'><?= lang('screen_sent_message_note') ?></span>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal"><?= lang('term_cancel') ?></a>
        <a href="#" id="btnSendMessage" class="btn btn-primary"><?= lang('term_send') ?></a>
    </div>
</div>

<div class='row'>
    <div class='span12'>
        <?
            $clock_class = 'active';
            if(!$state_clock){
                $clock_class = '';
            }
            $screen_class = 'icon-eye-open active';
            $extra_screen_class= '';
            if(!$state_screen){
                $screen_class = 'icon-eye-close';
                $extra_screen_class= 'disabled';
            }
        ?>

        <form class="form-horizontal center" action="<?= site_url($infoscreen->alias . '/update'); ?>" method="post" enctype="multipart/form-data">
            <div class="single-infoscreen">
                <div class="screen-links">
                    <a href="<?php echo site_url($infoscreen->alias . '/settings') ?>" class=''  data-step="5" data-intro="<?php echo lang('help_screen_settings'); ?>">
                        <i class='icon-cog'></i>&nbsp;
                        <?= lang('term_settings') ?></a>
                    <a href="<?php echo site_url($infoscreen->alias . '/shots') ?>" class=''  data-step="6" data-intro="<?php echo lang('help_screen_shots'); ?>">
                        <i class='icon-camera'></i>&nbsp;
                        <?= lang('term_screenshots') ?></a>
                </div>

                <div class="dummy"></div>
                <div class="screen <?= $extra_screen_class ?>">
                    <div class='inner'>
                        <a href="<?= site_url($infoscreen->alias . '/left') ?>">
                            <div class='left-side'>
                            </div>
                            <div class="clear"></div>
                        </a>
                        <a href="<?= site_url($infoscreen->alias . '/right') ?>">
                            <div class='right-side' style='background-color:<?= $infoscreen->color; ?>;'>
                            </div>
                        </a>

                        <div class="logo-holder" data-step="3" data-intro="<?php echo lang('help_screen_footer'); ?>">
                            <label for="inputFooter"><?= lang('term_footer') ?>:</label>
                            <div class="footer-line <?php if($footer_type == 'none') echo 'single';?>">
                                <select id='footerType' name='footer_type'>
                                    <?php
                                        foreach($footer_types as $footer_proto_type){
                                            echo "<option value='$footer_proto_type'";
                                            if($footer_type == $footer_proto_type) echo " selected='selected'";
                                            echo ">".lang('term_'.$footer_proto_type)."</option>";
                                        }
                                    ?>
                                </select>
                                <button type="submit" class="btn"><?= lang('term_save') ?></button>
                            </div>
                            <select id='inputFooterUpdates' name='footer_rss' class="updates <?php if($footer_type == "updates") echo "shown"; ?>">
                                <?php
                                    foreach($rss_links as $rss_link){
                                        echo "<option value='$rss_link->url'";
                                        if($footer == $rss_link->url) echo " selected='selected'";
                                        echo ">".$rss_link->name."</option>";
                                    }
                                ?>
                            </select>
                            <input type="text" id="inputFooterMessage" name="footer_message" placeholder="Text" class="<?php if($footer_type == "message") echo "shown"; ?>" value="<?php if($footer_type == "message") echo $footer; ?>"/>
                            <? if (!empty($infoscreen->logo)) { ?>
                                <div class='logo' style="background-image:url('<?= $infoscreen->logo; ?>?<?= rand(0, 999999) ?>');"></div>
                            <? } ?>
                        </div>
                    </div>
                </div>

                <ul class="pager">
                    <li class="previous">
                        <a href="<?= site_url($infoscreen->alias . '/left') ?>" data-step="1" data-intro="<?php echo lang('help_screen_left'); ?>">&larr; <?= lang('screen_left_side') ?></a>
                    </li>
                    <li class="next">
                        <a href="<?= site_url($infoscreen->alias . '/right') ?>"  data-step="2" data-intro="<?php echo lang('help_screen_right'); ?>"><?= lang('screen_right_side') ?> &rarr;</a>
                    </li>
                </ul>
            </div>

            <div class="btn-group" data-step="4" data-intro="<?php echo lang('help_screen_footer'); ?>">
                <a href='#messageModal' role='button' class="btn" data-toggle="modal" title="<?= lang('screen_sent_message_alt') ?>">
                    <i class="icon-comment icon-large"></i><br/>
                    <span><?= lang('screen_btn_message') ?></span>
                </a>
                <a href='#' id="btnToggleClock" role='button' class="btn" title="<?= lang('screen_toggle_clock_alt') ?>">
                    <i class="icon-time icon-large <?= $clock_class ?>"></i><br/>
                    <span><?= lang('screen_btn_clock') ?></span>
                </a>
                <a href='#' id="btnToggleScreen" role='button' class="btn"  title="<?= lang('screen_toggle_screen_alt') ?>">
                    <i class="<?= $screen_class ?> icon-large"></i><br/>
                    <span><?= lang('screen_btn_power') ?></span>
                </a>
                <a href='#' id='btnRefreshScreen' role='button' class="btn" title="<?= lang('screen_refresh') ?>">
                    <i class="icon-refresh icon-large"></i><br/>
                    <span><?= lang('screen_btn_refresh') ?></span>
                </a>
            </div>

        </form>
    </div>
</div>

<div class="alert fixed alert-message hide"></div>