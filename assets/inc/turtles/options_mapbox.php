<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term.location}}</label>
    <div class="controls">
        <select class='map-location-type'>
            {{map-options}}
        </select>
		<input type="text" id="{{id}}-name" name="{{id}}-name" placeholder="{{turtle.mapbox_alt}}" class='input-block-level mapbox-name {{custom_hide}} location' value="{{name}}"  style='margin-top: 10px'/>
	    <input type="hidden" id="{{id}}-location" name="{{id}}-location" class='input-block-level mapbox-location location' value="{{location}}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-limit">{{turtles.option_zoom}}</label>
    <div class="controls">
    	<select name="{{id}}-zoom" class='input-small'>
    		{{zoom-options}}
    	</select>
    </div>
</div>
<? include 'footer.php'; ?>