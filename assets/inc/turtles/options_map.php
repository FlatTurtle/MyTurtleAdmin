<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term_location}}</label>
    <div class="controls">
        <select class='map-location-type'>
            {{{map_options}}}
        </select>
        <input type="text" id="{{id}}-location" name="{{id}}-location" placeholder="{{turtle_mapbox_alt}}" class='input-block-level {{custom_hide}} map-location location' value="{{location}}" style='margin-top: 10px'/>
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
<div class="control-group">
    <label class="control-label" for="{{id}}-limit">{{turtles_option_zoomalt}}</label>
    <div class="controls">
        <select name="{{id}}-zoomalt" class='input-small'>
            {{{zoomalt_options}}}
        </select>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-zoomtime">Duration</label>
    <div class="controls">
        <input type="text" id="{{id}}-zoomtime" name="{{id}}-zoomtime" class='input-medium' value="{{zoomtime}}{{^zoomtime}}30{{/zoomtime}}"/>
        <span class='help-block'>{{turtle_map_zoomtime}}</span>
    </div>
</div>

<? include 'footer.php'; ?>
