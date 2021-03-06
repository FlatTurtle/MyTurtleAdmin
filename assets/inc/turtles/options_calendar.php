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
        <input type="text" id="{{id}}-url" name="{{id}}-url" placeholder="{{turtle_calendar_alt}}" class='input-block-level url' value="{{{url}}}"/>
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
<div class="control-group">
    <label class="control-label" for="{{id}}-nodescription">{{term_nodescription}}</label>
    <div class="controls">
        <input type="hidden" id="{{id}}-nodescription" name="{{id}}-nodescription" class='nodescription-field' value="{{nodescription}}"/>
        <input type="checkbox" id="{{id}}-nodescription" class='nodescription'/>
        <span class='help-block note'>{{turtle_calendar_nodescription_note}}</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-removeempty">{{term_removeempty}}</label>
    <div class="controls">
        <input type="hidden" id="{{id}}-removeempty" name="{{id}}-removeempty" class='removeempty-field' value="{{removeempty}}"/>
        <input type="checkbox" id="{{id}}-removeempty" class='removeempty'/>
        <span class='help-block note'>{{turtle_calendar_removeempty_note}}</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-todayonly">{{term_todayonly}}</label>
    <div class="controls">
        <input type="hidden" id="{{id}}-todayonly" name="{{id}}-todayonly" class='todayonly-field' value="{{todayonly}}"/>
        <input type="checkbox" id="{{id}}-todayonly" class='todayonly'/>
        <span class='help-block note'>{{turtle_calendar_todayonly_note}}</span>
    </div>
</div>
<? include 'footer.php'; ?>
