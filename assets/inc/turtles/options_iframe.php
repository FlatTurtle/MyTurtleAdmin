<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-link">{{term_link}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-link" name="{{id}}-link" placeholder="{{turtle_iframe_link_alt}}" class='input-medium' value="{{link}}"/>
        <br/><span class='note'>{{turtle_iframe_link_note}}</span>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-zoom">{{term_zoom}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-zoom" name="{{id}}-zoom" placeholder="{{turtle_iframe_zoom_alt}}" class='input-medium' value="{{zoom}}"/>
        <br/><span class='note'>{{turtle_iframe_zoom_note}}</span>
  </div>
</div>
<? include 'footer.php'; ?>

