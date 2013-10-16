<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-search">{{term_search}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-search" name="{{id}}-search" placeholder="{{turtle_twitter_search_alt}}" class='input-large' value="{{search}}"/>
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