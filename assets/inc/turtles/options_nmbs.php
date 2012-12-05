<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">Location</label>
    <div class="controls">
		<input type="text" id="{{id}}-location" name="{{id}}-location" placeholder="Name of a station (ex. Gent Sint-Pieters)" class='input-block-level autocomplete nmbs-location' value="{{location}}"/>
	</div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-limit">Items to show</label>
    <div class="controls">
		<select name="{{id}}-limit" class='input-small'>
			{{limit-options}}
		</select>
	</div>
</div>
<? include 'footer.php'; ?>