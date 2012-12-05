<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">Location</label>
    <div class="controls">
		<input type="text" id="{{id}}-name" name="{{id}}-name" placeholder="Name of a Velo station (ex. Theater)" class='input-block-level autocomplete velo-name' value="{{name}}"/>
		<input type="hidden" id="{{id}}-location" name="{{id}}-location" class='input-block-level velo-location' value="{{location}}"/>
	</div>
</div>
<? include 'footer.php'; ?>