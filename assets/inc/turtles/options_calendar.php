<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-header">{{term_title}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-header" name="{{id}}-header" placeholder="Calendar" class='input-large' value="{{header}}"/>
        <span class='note'> {{term_optional}}</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-url">ICAL</label>
    <div class="controls">
        <input type="text" id="{{id}}-url" name="{{id}}-url" placeholder="{{turtle_calendar_alt}}" class='input-block-level url' value="{{url}}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-filter">{{term_filter}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-filter" name="{{id}}-filter" class='input-large filter' value="{{filter}}"/>
        <span class='note'> {{term_optional}}</span><br/>
        <span class='help-block note'>{{turtle_calendar_filter}}</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-size">{{term_larger}}</label>
    <div class="controls">
        <input type="hidden" id="{{id}}-size" name="{{id}}-size" class='size-field' value="{{size}}"/>
        <input type="checkbox" id="{{id}}-larger" class='make-larger'/>
        <span class='help-block note'>{{turtle_twitter_larger_note}}</span>
    </div>
</div>
<? include 'footer.php'; ?>