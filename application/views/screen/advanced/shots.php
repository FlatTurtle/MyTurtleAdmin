<div class="row">
    <?php
        $item = 0;
        foreach($shots as $shot){
    ?>
        <div class='span3'>
            <a href='data:image/png;base64,<?= $shot ?>' target="_blank">
                <img src="data:image/png;base64,<?= $shot ?>" />
            </a>
            <br/>
            <br/>
        </div>
    <?
            $item++;

            // Break new row
            if($item%4 == 0){
                echo "</div><div class='row'>";
            }
        }
    ?>
</div>