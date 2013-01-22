<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-feed">{{term.feed}}</label>
    <div class="controls">
        <select class='rss-feed-type'>
            {{rss-links}}
        </select>
		<input type="text" id="{{id}}-feed" name="{{id}}-feed" placeholder="{{turtle.rss_alt}}" class='input-block-level rss-feed {{custom_hide}}' value="{{feed}}" style='margin-top: 10px'/>
    </div>
</div>
<? include 'footer.php'; ?>