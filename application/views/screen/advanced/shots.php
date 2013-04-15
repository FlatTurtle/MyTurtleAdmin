<div class="row">
    <div class='span12'>
        <div id='infoscreens'>
            <?php
                $item = 0;
                foreach($shots as $shot){
            ?>

                <div class='infoscreen'>
                    <div class='screen'>
                        <a href='data:image/png;base64,<?= $shot ?>' target="_blank">
                            <img src="data:image/png;base64,<?= $shot ?>" />
                        </a>
                        <br/>
                        <br/>
                    </div>
                </div>
            <?
                }
            ?>
        </div>
    </div>
</div>