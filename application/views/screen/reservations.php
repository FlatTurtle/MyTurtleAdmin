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
	
	<div class='span12'>
	
    
    <h1>Calendar for all user's future reservations</h1>
    <p>Maybe this one https://github.com/Serhioromano/bootstrap-calendar </p>

    <? if(isset($rooms)) {?>
            <h2>Rooms [<?= count($rooms) ?>] 
                <small class='pull-right'>
                    <a class="btn btn-lg btn-block pull-right span2" href="<?= site_url($infoscreen->alias.'/reservations/rooms/create'); ?>"  
                        id="createNewRoom" name="createNewRoom"><i class='icon-plus'></i>  Create room</a>
                </small>
            </h2>
            <div class="row-fluid cards cards-50 cards-bordered">
            <div class="span10 offset2">
        <? foreach($rooms as $room){?>
            
            <a href="<?= site_url($infoscreen->alias.'/reservations/rooms/'.$room->name); ?>">
              <ul class="card" class="span12">
                <li>
                <blockquote>
                  <p><?= $room->name; ?></p>
                  <small><?= $room->description; ?></small>
                </blockquote>
                </li>
              </ul>
            </a>
            
        <?}?>
        </div>
        </div>
    <?}?>
    

    <? if(isset($amenities)) {?>
            <h2>Amenities [<?= count($amenities) ?>]
                <small class='pull-right'>
                    <a class="btn btn-lg btn-block pull-right span2" href="<?= site_url($infoscreen->alias.'/reservations/amenities/create'); ?>" 
                        id="createNewAmenity" name="createNewAmenity"><i class='icon-plus'></i>  Create amenity</a>
                </small>
            </h2>
            <div class="row-fluid cards cards-50 cards-bordered">
            <div class="span10 offset2">
            <? foreach($amenities as $amenity){?>
            
            <a href="<?= site_url($infoscreen->alias.'/reservations/amenities/'.$amenity->title); ?>">
              <ul class="card" class="span12">
                <li>
                <blockquote>
                  <p><?= $amenity->title; ?></p>
                  <small><?= $amenity->description; ?></small>
                </blockquote>
                </li>
              </ul>
            </a>
            
        <?}?>
        </div>
        </div>
    <?}?>




    </div>
</div>


		