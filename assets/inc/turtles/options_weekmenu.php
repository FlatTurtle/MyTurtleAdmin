<? include 'header.php' ?>
<input type="hidden" id="{{id}}-data" name="{{id}}-data" class='input-block-level weekmenu-data' value='{{{data}}}'/>
<div class="control-group">
    <label class="control-label">{{ turtle_weekmenu_title_alt }}</label>
    <div class="controls">
        <input type="text" id="weekmenu-title" name="weekmenu-title" class="input-block-level" />
    </div>

</div>
<div class="control-group">
    <label class="control-label">{{ turtle_weekmenu_today_title_alt }}</label>
    <div class="controls">
        <input type="text" id="today-title" name="today-title" class="input-block-level" />
    </div>
    <hr/>
</div>


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