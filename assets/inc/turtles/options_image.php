<? include 'header.php'; ?>
<div id="{{id}}-data" style="display:none" >
    <script  type="application/json">
        {{{data}}}
    </script>
</div>
<div class="control-group">
    <label class="control-label" for="{{id}}-duration">Duration</label>
    <div class="controls">
        <input type="text" id="{{id}}-duration" name="{{id}}-duration" class='input-medium' value="{{duration}}"/>
        <span class='help-block'>Duration in ms (e.g 4000, for 4 seconds)</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Slides</label>
    <div class="controls">
        <!--<textarea id="{{id}}-urls" name="{{id}}-urls" rows="10">{{&urls}}</textarea>-->
        <p>Uploaded slides can be reordered by dragging and dropping</p>
        <button id="add-slide" class="btn btn-small">Add slide</button>
        <div>
            <ul id="slide-sorter">
                <!-- slides will get inserted here -->
            </ul>
        </div>

        <!-- modal window to handle cropping and uploading of slides -->
        <div id="upload-modal">
            <div class="header">
                <h1>Slide uploading and cropping</h1>

                <form enctype='multipart/form-data'>
                    <input type='file' name='slide-upload' id="slide-upload" class='slide-image-file' data-turtle-id='{{id}}'/>
                </form>
            </div>

            <!-- portrait cropping -->
            <div id="portrait">

                <div class="content">
                    <p>Choose which part of the image you want to keep for portrait view</p>
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
                    <p>Choose which part of the image you want to keep for landscape (full screen) view</p>
                    <!-- full sized image gets inserted here to get cropped -->
                    <div class="image-container"></div>
                    <input type="hidden" id="land_x1"/>
                    <input type="hidden" id="land_y1"/>
                    <input type="hidden" id="land_x2"/>
                    <input type="hidden" id="land_y2"/>
                </div>
            </div>

            <div class="footer">
                <button class="btn" id="modal-finish">Finish</button>
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