<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term.primary}}</label>
    <div class="controls">
		<input type="text" id="{{id}}-primary" name="{{id}}-primary" placeholder="{{turtle.finance_primary_alt}}" class='input-small' value="{{primary}}"/>
	    <br/><span class='note'>{{turtle.finance_primary_note}}</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term.secondary}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-secondary" name="{{id}}-secondary" placeholder="{{turtle.finance_secondary_alt}}" class='input-block-level' value="{{secondary}}"/>
        <span class='note'>{{turtle.finance_secondary_note}}</span>
    </div>
</div>
<? include 'footer.php'; ?>