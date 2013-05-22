<? include 'header.php'; ?>
<input type="hidden" id="{{id}}-data" name="{{id}}-data" class='input-block-level signage-data' value='{{{data}}}'/>
<div class='floors'></div>
<div class="control-group">
    <div class="controls">
        <button id="add-floor" class="btn btn-small">{{turtle_signage_add_floor}}</button>
        <br/>
        <span class='note'>{{turtle_signage_save_alt}}</span>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        buildSignage($('#{{id}}-data').val());
    })
</script>
<? include 'footer.php'; ?>