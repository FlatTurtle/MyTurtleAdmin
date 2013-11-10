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
		<? if(isset($amenities)) {?>
			<h1>Amenities <?= count($amenities) ?></h1>
			
		<?}?>
		
		<div class='room-chooser sortable span3'>
        <?
        if(!empty($amenities)){
        ?>
        <h4><?= lang('rooms_enabled') ?></h4>
        <div class="sortable" data-step="1" data-intro="<?php echo lang('help_rooms_enabled'); ?>">
        <?
        	$extra_class = "";
            // Show all enabled panes
            foreach($amenities as $amenity){
                if($amenity->id == $amenity->id)  $extra_class = "active";
        ?>
                    <div id="amenity_<?= $amenity->id; ?>" class='amenity draggable <?= $extra_class ?>'>
                        <a href='<?= site_url($infoscreen->alias.'/reservations/amenity/'.$amenity->id. "#config"); ?>'>
                            <div class='holder'>
                            <?
                                echo $amenity->title;
                                if(!empty($amenity->description)){
                                    echo "<span class='note'>".$amenity->description."</span>";
                                }
                            ?>
                            </div>
                        </a>
                    </div>
            <?}?>
        </div>
        <?}?>
        <a href="<?= site_url($infoscreen->alias.'/reservations/amenities/create'); ?>" class="btn"><i class="icon-plus"></i> Add new amenity</a>
		</div>
	</div>
    <div class='span9'>

    </div>
</div>
