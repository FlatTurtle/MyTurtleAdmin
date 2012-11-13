<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">Location</label>
    <div class="controls">
		<input type="text" id="{{id}}-location" name="{{id}}-location" placeholder="Code of an airport (ex. BRU)" class='input-block-level airport-location' value="{{location}}"/>
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