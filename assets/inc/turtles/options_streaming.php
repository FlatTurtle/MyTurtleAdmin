<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-stream">{{term_stream}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-stream" name="{{id}}-stream" placeholder="{{turtle_streaming_stream_alt}}" class='input-medium' value="{{stream}}"/>
        <br/><span class='note'>{{turtle_streaming_stream_note}}</span>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-videoid">{{term_videoid}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-videoid" name="{{id}}-videoid" placeholder="{{turtle_streaming_videoid_alt}}" class='input-medium' value="{{videoid}}"/>
        <br/><span class='note'>{{turtle_streaming_videoid_note}}</span>
  </div>
</div>
<? include 'footer.php'; ?>

