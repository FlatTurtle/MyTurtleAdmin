<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term_location}}</label>
    <div class="controls">
        <select class='map-location-type'>
            {{{map_options}}}
        </select>
        <input type="text" id="{{id}}-name" name="{{id}}-name" placeholder="{{turtle_mapbox_alt}}" class='input-block-level mapbox-name {{custom_hide}} location' value="{{name}}"  style='margin-top: 10px'/>
        <input type="hidden" id="{{id}}-location" name="{{id}}-location" class='mapbox-location location' value="{{location}}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-limit">{{turtles_option_zoom}}</label>
    <div class="controls">
        <select name="{{id}}-zoom" class='input-small'>
            {{{zoom_options}}}
        </select>
    </div>
</div>
<? include 'footer.php'; ?>