<? include 'header.php' ?>
<input type="hidden" id="{{id}}-data" name="{{id}}-data" class='input-block-level offers-data' value='{{{data}}}'/>

<div class="offer-wrapper "></div>
<div class="control-group">
    <div class="controls">
        <button id="add-offer" class="btn btn-small">{{ turtle_weekmenu_add_offer }}</button>
    </div>
    <hr/>
</div>
<script>
    $(document).ready(function(){
        buildOffers($('#{{id}}-data').val());
    });
</script>
<? include 'footer.php' ?>