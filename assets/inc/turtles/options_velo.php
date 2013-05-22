<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term_location}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-name" name="{{id}}-name" placeholder="{{turtle_velo_alt}}" class='input-block-level autocomplete velo-name' value="{{name}}"/>
        <input type="hidden" id="{{id}}-location" name="{{id}}-location" class='input-block-level velo-location' value="{{location}}"/>
        <input type="hidden" id="{{id}}-time_walk" name="{{id}}-time_walk" class='velo-time_walk time_walk' value="{{time_walk}}"/>
    </div>
</div>
<? include 'footer.php'; ?>