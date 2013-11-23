<div class="row">
    <div class="span12">
        <form class="form-horizontal center">
            <div class="control-group">
                <div class="controls">
                    <p><?= lang('maps_info') ?>More info <a href="#">here</a></p>
                </div>
            </div>
            <div class="control-group">
                <label for="width" class="control-label"><?= lang('term_width') ?></label>
                <div class="controls">
                    <input type="text" name="width" id="width" value="100">
                </div>
            </div>
            <div class="control-group">
                <label for="height" class="control-label"><?= lang('term_height') ?></label>
                <div class="controls">
                    <input type="text" name="height" id="height" value="100">
                </div>
            </div>
            <div class="control-group">
                <label for="maps-units-pct" class="control-label"><?= lang('maps_px') ?></label>
                <div class="controls">
                    <input type="radio" value="px" name="maps-units" id="maps-units-px">
                </div>
            </div>
            <div class="control-group">
                <label for="maps-units-pct" class="control-label"><?= lang('maps_pct') ?></label>
                <div class="controls">
                    <input type="radio" value="%" name="maps-units" id="maps-units-pct" checked="checked">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button id="generate-code" class="btn btn-small"><?= lang('maps_generate') ?></button>
                </div>
            </div>
            <div class="control-group">
                <div id="generated"></div>

            </div>
        </form>

        <script>
            (function(){
                // bind button click
                $("#generate-code").off().on('click', function(e){
                    e.preventDefault();

                    generate_code();
                });

                function generate_code(){
                    var alias = "<?= $infoscreen->alias ?>";

                    // get width
                    var width = $("#width").val();
                    if(isNaN(width) || width == ""){
                        //just use default value
                        width = 100;
                    }

                    // get height
                    var height = $("#height").val();
                    if(isNaN(height) || height == ""){
                        //just use default value
                        height = 100;
                    }

                    // get units
                    var units = $('input[name="maps-units"]:checked').val();

                    // generate maps iframe
                    var code = '<iframe width="' + width + units + '" height="' + height + units + '" frameborder="0"' +
                            'scrolling="no" marginheight="0" marginwidth="0"' +
                            'src="https://maps.flatturtle.com/' + alias + '"></iframe>';

                    var encoded = $('<div/>').text(code).html();
                    $("#generated").empty().append("<pre>" + encoded + "</pre>");
                }
            }());


        </script>
    </div>
</div>