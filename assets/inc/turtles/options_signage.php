<? include 'header.php'; ?>
<div id="{{id}}-data" style="display:none" >
    <script  type="application/json">
        {{{data}}}
    </script>
</div>

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
        buildSignage($('#{{id}}-data script').text().trim(), $('#{{id}}-data').parents('.turtle_signage'));
    })
</script>
<? include 'footer.php'; ?>