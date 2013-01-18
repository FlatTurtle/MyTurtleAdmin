<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term.location}}</label>
    <div class="controls">
		<input type="text" id="{{id}}-name" name="{{id}}-name" placeholder="{{turtle.villo_alt}}" class='input-block-level autocomplete villo-name' value="{{name}}"/>
		<input type="hidden" id="{{id}}-location" name="{{id}}-location" class='input-block-level villo-location' value="{{location}}"/>
	</div>
</div>
<? include 'footer.php'; ?>