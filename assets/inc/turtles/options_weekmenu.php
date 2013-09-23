<? include 'header.php' ?>
<input type="hidden" id="{{id}}-data" name="{{id}}-data" class='input-block-level weekmenu-data' value='{{{data}}}'/>
<div class="categories"></div>
<div class="control-group">
    <div class="controls">
        <button id="add-category" class="btn btn-small">{{ turtle_pricelist_add_category }}</button>
    </div>
    <hr/>
</div>
<script>
    $(document).ready(function(){
        buildWeekMenu($('#{{id}}-data').val(), $('#{{id}}-data').parents('.turtle_weekmenu'));
    });
</script>
<? include 'footer.php' ?>