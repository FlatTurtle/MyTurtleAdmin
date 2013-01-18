<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term.location}}</label>
    <div class="controls">
		<input type="text" id="{{id}}-location" name="{{id}}-location" placeholder="{{turtle.airport_alt}}" class='input-block-level airport-location' value="{{location}}"/>
	</div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-limit">{{turtles.option_number_of_items}}</label>
    <div class="controls">
		<select name="{{id}}-limit" class='input-small'>
			{{limit-options}}
		</select>
	</div>
</div>
<? include 'footer.php'; ?>