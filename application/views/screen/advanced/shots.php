<div class="row">
    <div class='span12'>
        <div id='infoscreens'>
            <?php
                $item = 0;
                foreach($shots as $shot){
            ?>

                <div class='infoscreen'>
                    <div class='screen'>
                        <a href='data:image/png;base64,<?= $shot->data ?>' target="_blank">
                            <img src="data:image/png;base64,<?= $shot->data ?>" />
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