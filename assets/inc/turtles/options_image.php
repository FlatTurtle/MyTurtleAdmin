<? include 'header.php'; ?>

<div class="control-group">
    <label class="control-label" for="{{id}}-duration">Duration</label>
    <div class="controls">
        <input type="text" id="{{id}}-duration" name="{{id}}-duration" class='input-medium' value="{{duration}}"/>
        <span class='help-block'>Duration in ms (e.g 4000, for 4 seconds)</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-urls">URLS</label>
    <div class="controls">
        <textarea id="{{id}}-urls" name="{{id}}-urls" rows="10">{{&urls}}</textarea>
    </div>
</div>

<? include 'footer.php'; ?>