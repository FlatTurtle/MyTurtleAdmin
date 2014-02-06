<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-region">{{term_region}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-region" name="{{id}}-region" placeholder="{{turtle_navitia_region_alt}}" class='input-block-level autocomplete navitia-region' value="{{region}}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term_location}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-location" name="{{id}}-location" placeholder="{{turtle_navitia_location_alt}}" class='input-block-level autocomplete navitia-location' value="{{location}}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-stop_point">{{turtle_navitia_stop_point}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-stop_point" name="{{id}}-stop_point" placeholder="{{turtle_navitia_stop_point_alt}}" class='input-block-level autocomplete navitia-stop_point' value="{{stop_point}}"/>
    </div>
</div>
<? include 'footer.php'; ?>
