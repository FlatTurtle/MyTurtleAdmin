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
                        <a href="<?= site_url($link); ?>/reservations">&larr; Back</a>
                    </li>
                </ul>
    </div>
    
</div>
<div class='row'>

	<div class='span10 offset2'>
    <h3>
        <?= $room->name ?>
        <small class="pull-right">
        <a href="#" class="btn"><i class="icon-edit"></i> Edit room</a>
        <a href="#" class="btn"><i class="icon-remove"></i> Delete room</a>
        </small>
    </h3>
	</div>
</div>


		