<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-search">{{term.search}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-search" name="{{id}}-search" placeholder="{{turtle.twitter_search_alt}}" class='input-large' value="{{search}}"/>
    </div>
</div>
<? include 'footer.php'; ?>