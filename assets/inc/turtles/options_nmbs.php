<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term_location}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-location" name="{{id}}-location" placeholder="{{turtle_nmbs_alt}}" class='input-block-level autocomplete nmbs-location' value="{{location}}"/>
        <input type="hidden" id="{{id}}-time_walk" name="{{id}}-time_walk" class='nmbs-time_walk time_walk' value="{{time_walk}}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-limit">{{turtles_option_number_of_items}}</label>
    <div class="controls">
        <select name="{{id}}-limit" class='input-small'>
            {{{limit_options}}}
        </select>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-destination">{{term_via}} ({{term_optional}})</label>
    <div class="controls">
        <input type="text" id="{{id}}-destination" name="{{id}}-destination" placeholder="{{turtle_nmbs_alt}}" class='input-block-level autocomplete nmbs-via' value="{{destination}}"/>
        <span class='note'>
            {{turtle_nmbs_via_alt}}
        </span>
    </div>
</div>
<? include 'footer.php'; ?>