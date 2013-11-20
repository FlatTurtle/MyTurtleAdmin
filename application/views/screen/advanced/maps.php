<div class="row">
    <div class="span12">
        <form action="<?= site_url($infoscreen->alias . '/settings/update'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal center">
            <div class="control-group">
                <label for="" class="control-label"><?= lang('term_width') ?></label>
                <div class="controls">
                    <input type="text" name="width" id="width">
                </div>
            </div>
            <div class="control-group">
                <label for="height" class="control-label"><?= lang('term_height') ?></label>
                <div class="controls">
                    <input type="text" name="height" id="height">
                </div>
            </div>
        </form>
        <pre id="generated">
            
        </pre>
        <script>
            var code = '<iframe width="100%" height="100%" frameborder="0" 
                        scrolling="no" marginheight="0" marginwidth="0"   
                        src="https://maps.flatturtle.com/flatturtle"></iframe>'
            $("#generated").append();
        </script>
    </div>
</div>