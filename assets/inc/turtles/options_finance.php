<? include 'header.php'; ?>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term_primary}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-primary" name="{{id}}-primary" placeholder="{{turtle_finance_primary_alt}}" class='input-small' value="{{primary}}"/>
        <br/><span class='note'>{{turtle_finance_primary_note}}</span>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-location">{{term_secondary}}</label>
    <div class="controls">
        <input type="text" id="{{id}}-secondary" name="{{id}}-secondary" placeholder="{{turtle_finance_secondary_alt}}" class='input-block-level' value="{{secondary}}"/>
        <span class='note'>{{turtle_finance_secondary_note}}</span>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <span class='note'>{{ turtle_finance_lookup_note }} <a href="http://finance.yahoo.com/marketupdate/overview">{{term_link}}</a></span>
    </div>

</div>
<? include 'footer.php'; ?>