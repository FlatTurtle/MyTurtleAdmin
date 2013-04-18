<div class="row">
    <div class='span12'>
        <div class='infoscreens'>
            <?php
                $item = 0;
                foreach($shots as $shot){
            ?>

                <div class='infoscreen'>
                    <div class='screen'>
                        <a href='<?= site_url($infoscreen->alias.'/shot/'.$shot->name); ?>' target="_blank">
                            <img src="data:image/jpg;base64,<?= $shot->data ?>" />
                        </a>
                        <br/>
                        <br/>
                    </div>
                    <?= $shot->title ?>
                </div>
            <?
                }
            ?>
        </div>
    </div>
</div>