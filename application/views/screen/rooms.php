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
    
</div>
<div class='row'>
	<div class='span3'>
		<? if(isset($rooms)) {?>
			<h1>Rooms <?= count($rooms) ?></h1>
			
		<?}?>
		
		<div class='room-chooser sortable span3'>
        <?
        if(!empty($rooms)){
        	
        ?>
        <h4><?= lang('rooms_enabled') ?></h4>
        <div class="sortable" data-step="1" data-intro="<?php echo lang('help_rooms_enabled'); ?>">
        <?
        	$extra_class = "";
            // Show all enabled panes
            foreach($rooms as $room){
            	if($room->type=='room'){
                //if($room->id == $room->id)  $extra_class = "active";
        ?>
                    <div id="room_<?= $room->name; ?>" class='room draggable <?= $extra_class ?>'>
                        <a href='<?= site_url($infoscreen->alias."/reservations/rooms/".$room->name . "#config"); ?>'>
                            <div class='holder'>
                            <?
                                echo $room->name;
                                if(!empty($room->description)){
                                    echo "<span class='note'>".$room->description."</span>";
                                }
                            ?>
                            </div>
                        </a>
                    </div>
            <?}}?>
        </div>
        <?}?>
        <a href="#" class="btn"><i class="icon-plus"></i> Add new room</a>
		</div>
	</div>
	<div class='span9'>
	</div>



    </div>
</div>


		