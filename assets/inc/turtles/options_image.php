<? include 'header.php'; ?>
<div id="{{id}}-data" style="display:none" >
    <script  type="application/json">
        {{{data}}}
    </script>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-duration">Duration</label>
    <div class="controls">
        <input type="text" id="{{id}}-duration" name="{{id}}-duration" class='input-medium' value="{{duration}}{{^duration}}4000{{/duration}}"/>
        <span class='help-block'>{{turtle_image_duration}}</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Slides</label>
    <div class="controls">
        <!--<textarea id="{{id}}-urls" name="{{id}}-urls" rows="10">{{&urls}}</textarea>-->
        <p>{{turtle_image_drag_drop_note}}</p>
        <button id="add-slide" class="btn btn-small">{{turtle_image_add_slide}}</button>
        <div>
            <ul id="slide-sorter">
                <!-- slides will get inserted here -->
            </ul>
        </div>

        <!-- modal window to handle cropping and uploading of slides -->
        <div id="upload-modal">
            <div class="header">
                <h1>{{turtle_image_uploading}}</h1>
                <!-- temporary upload spinner until PUT and progress bar -->
                <i class='uploading fade'></i>

                <form enctype='multipart/form-data'>
                    <input type='file' name='slide-upload' id="slide-upload" class='slide-image-file' data-turtle-id='{{id}}'/>
                </form>
            </div>

            <!-- portrait cropping -->
            <div id="portrait">

                <div class="content">
                    <p>{{turtle_image_crop_portrait}}</p>
                    <!-- full sized image gets inserted here to get cropped -->
                    <div class="image-container"></div>
                    <input type="hidden" id="port_x1"/>
                    <input type="hidden" id="port_y1"/>
                    <input type="hidden" id="port_x2"/>
                    <input type="hidden" id="port_y2"/>
                </div>
            </div>

            <!-- landscape cropping -->
            <div id="landscape">
                <div class="content">
                    <p>{{turtle_image_crop_landscape}}</p>
                    <!-- full sized image gets inserted here to get cropped -->
                    <div class="image-container"></div>
                    <input type="hidden" id="land_x1"/>
                    <input type="hidden" id="land_y1"/>
                    <input type="hidden" id="land_x2"/>
                    <input type="hidden" id="land_y2"/>
                </div>
            </div>

            <div class="footer">
                <button class="btn" id="modal-finish">{{turtle_image_add_slide}}</button>
            </div>
        </div>
        <div id="modal-fade">
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        buildImage($('#{{id}}-data script').text().trim(), $('#{{id}}-data').parents('.turtle_image'));
    });
</script>
<? include 'footer.php'; ?>