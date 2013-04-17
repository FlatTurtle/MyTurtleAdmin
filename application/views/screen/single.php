<div id="messageModal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?= lang('screen.sent_message') ?></h3>
    </div>
    <div class="modal-body">
        <input id='the_message' class="input-block-level"/><br/>
        <span class='note'><?= lang('screen.sent_message_note') ?></span>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal"><?= lang('term.cancel') ?></a>
        <a href="#" id="btnSendMessage" class="btn btn-primary"><?= lang('term.send') ?></a>
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
        <div class="single-infoscreen">
            <div class="dummy"></div>
            <div class="screen <?= $extra_screen_class ?>">
                <div class='inner'>
                    <a href="<?= site_url($infoscreen->alias . '/left') ?>">
                        <div class='left-side'>
                        </div>
                    </a>
                    <a href="<?= site_url($infoscreen->alias . '/right') ?>">
                        <div class='right-side' style='background-color:<?= $infoscreen->color; ?>;'>
                        </div>
                    </a>

                    <div class="logo-holder">
                        <? if (!empty($infoscreen->logo)) { ?>
                            <div class='logo' style="background-image:url('<?= $infoscreen->logo; ?>?<?= rand(0, 999999) ?>');"></div>
                        <? } ?>
                    </div>
                </div>
            </div>

            <ul class="pager">
                <li class="previous">
                    <a href="<?= site_url($infoscreen->alias . '/left') ?>">&larr; <?= lang('screen.left_side') ?></a>
                </li>
                <li class="next">
                    <a href="<?= site_url($infoscreen->alias . '/right') ?>"><?= lang('screen.right_side') ?> &rarr;</a>
                </li>
            </ul>
        </div>

        <form class="form-horizontal center" action="<?= site_url($infoscreen->alias . '/update'); ?>" method="post" enctype="multipart/form-data">
            <div class="btn-group">
                <a href='#messageModal' role='button' class="btn" data-toggle="modal" title="<?= lang('screen.sent_message_alt') ?>">
                    <i class="icon-comment icon-large"></i><br/>
                    <span><?= lang('screen.btn_message') ?></span>
                </a>
                <a href='#' id="btnToggleClock" role='button' class="btn" title="<?= lang('screen.toggle_clock_alt') ?>">
                    <i class="icon-time icon-large <?= $clock_class ?>"></i><br/>
                    <span><?= lang('screen.btn_clock') ?></span>
                </a>
                <a href='#' id="btnToggleScreen" role='button' class="btn"  title="<?= lang('screen.toggle_screen_alt') ?>">
                    <i class="<?= $screen_class ?> icon-large"></i><br/>
                    <span><?= lang('screen.btn_power') ?></span>
                </a>
                <a href='#' id='btnRefreshScreen' role='button' class="btn" title="<?= lang('screen.refresh') ?>">
                    <i class="icon-refresh icon-large"></i><br/>
                    <span><?= lang('screen.btn_refresh') ?></span>
                </a>
            </div>


            <div class="btn-secondrow">
                <a href="<?php echo site_url($infoscreen->alias . '/settings') ?>" class=''>
                    <i class='icon-cog'></i>&nbsp;
                    <?= lang('term.settings') ?></a>
                <a href="<?php echo site_url($infoscreen->alias . '/shots') ?>" class=''>
                    <i class='icon-camera'></i>&nbsp;
                    <?= lang('term.screenshots') ?></a>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputFooter"><?= lang('term.footer') ?></label>
                <input type="hidden" name="" value="<?= $footer ?>"/>
                <div class="controls">
                    <select id='footerType' name='footer_type'>
                        <?php
                            foreach($footer_types as $footer_proto_type){
                                echo "<option value='$footer_proto_type'";
                                if($footer_type == $footer_proto_type) echo " selected='selected'";
                                echo ">".lang('term.'.$footer_proto_type)."</option>";
                            }
                        ?>
                    </select>
                    <select id='inputFooterUpdates' name='footer_rss' class="<?php if($footer_type == "updates") echo "shown"; ?>">
                        <?php
                            foreach($rss_links as $rss_link){
                                echo "<option value='$rss_link->url'";
                                if($footer == $rss_link->url) echo " selected='selected'";
                                echo ">".$rss_link->name."</option>";
                            }
                        ?>
                    </select>
                    <input type="text" id="inputFooterMessage" name="footer_message" placeholder="Text" class="<?php if($footer_type == "message") echo "shown"; ?>" value="<?php if($footer_type == "message") echo $footer; ?>"/>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <? if (!empty($all_errors) || !empty($file_error)) { ?>
                        <div class="alert alert-error">
                            <?= $file_error ?>
                            <?= (!empty($file_error)) ? '<br/>' : ''; ?>
                            <?= $all_errors; ?>
                        </div>
                        <button type="submit" class="btn"><?= lang('term.retry') ?></button>
                        <a href="<?= site_url($infoscreen->alias) ?>" class="btn"><?= lang('term.cancel') ?></a>
                    <? } else { ?>
                        <button type="submit" class="btn"><?= lang('term.save') ?></button>
                    <? } ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="alert fixed alert-message hide">
    <strong>Warning!</strong> Best check yo self, you're not looking too good.
</div>