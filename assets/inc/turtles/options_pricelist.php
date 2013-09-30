<? include 'header.php'; ?>
<div id="{{id}}-data" style="display:none" >
    <script  type="application/json">
        {{{data}}}
    </script>
</div>
<div class="control-group">
    <label class="control-label">{{ term_title }}</label>
    <div class="controls">
        <input type="text" id="title" name="title" class="input-block-level" placeholder="{{turtle_pricelist_title_alt}}"/>
    </div>
    <hr/>
</div>

<div class="categories"></div>
<div class="control-group">
    <div class="controls">
        <button id="add-category" class="btn btn-small">{{ turtle_pricelist_add_category }}</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        buildPriceList($('#{{id}}-data script').text().trim(), $('#{{id}}-data').parents('.turtle_pricelist'));
    });
</script>
<? include 'footer.php'; ?>