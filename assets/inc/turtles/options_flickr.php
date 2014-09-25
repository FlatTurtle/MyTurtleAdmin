<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-userid">{{term_userid}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-userid" name="{{id}}-userid" placeholder="{{turtle_flickr_userid__alt}}" class='input-small' value="{{userid}}"/>
        <br/><span class='note'>{{turtle_flickr_userid_note}}</span>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-limit">{{turtles_option_number_of_items}}</label>
    <div class="controls">
        <select name="{{id}}-limit" class='input-small'>
            {{{limit_options}}}
        </select>
    </div>
</div>

<? include 'footer.php'; ?>

