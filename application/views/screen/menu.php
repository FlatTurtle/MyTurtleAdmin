<div class='row submenu'>
    <div class='span3'>
        <ul class="pager backlink">
            <li class="previous">
                <?php
                    $link = $infoscreen->alias;
                    if(isset($back_link)){
                        $link = $back_link;
                    }
                ?>
                <a href="<?= site_url($link); ?>">&larr; Back</a>
            </li>
        </ul>
    </div>
    <div class='span9'>
        <h3>
            <?= $infoscreen->title; ?>
            <?php
                if(isset($menu_second_item))
                    echo "&nbsp;<i class='icon-chevron-right'></i>&nbsp;". $menu_second_item;
            ?>
        </h3>
        <?php
        // Advanced is only for superadmins
        if($this->uri->segment(3) != "advanced"){
        ?>
            <a href="<?php echo site_url($infoscreen->alias . '/advanced') ?>" class='btn pull-right'>
                <i class='icon-cog'></i>&nbsp;
                <?= lang('term.advanced') ?>
            </a>
        <?php
        }
        ?>
    </div>
</div>