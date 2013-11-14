$("#slide-sorter")
    .sortable()
    .disableSelection();

function buildImage(data, instance){
    if(data && data != ""){
        var urls = JSON.parse(data);

        var slide_sorter = $("#slide-sorter", instance);
        for(var url in urls){
            slide_sorter.append(createSlide(urls[url]));
        }
    }

    bindImageEvents();
}

function createSlide(url){
    // find out file id
    var segments = url.split('/');
    var last_segment = segments[segments.length-1];
    var id = last_segment.split('-')[0];

    // thumbnail holder and draggable
    var thumb_holder = $("<li class='slide' data-id='" + id + "'></li>");

    //creating remove button
    var header = $("<div class='header'></div>");
    var remove_button = $("<a href='#' class='btn remove-slide'>x</a>");
    header.append(remove_button);
    thumb_holder.append(header);

    //image thumbnail
    var thumb = $("<img src='"+ url + "'/> ");
    thumb_holder.append(thumb);

    return thumb_holder;
}

function saveSlideshow(instance){
    var urls = [];
    $("#slide-sorter .slide", instance).each(function(){
        var url = $(this).find("img").attr('src');
        urls.push(url)
    });

    return JSON.stringify(urls);
}

// clears all dynamic data in the upload modal box
function clearUploadModal(){
    var $portrait = $("#portrait");
    var $landscape = $("#landscape");
    // clear modal box
    $portrait.find(".content .image-container").empty();
    $landscape.find(".content .image-container").empty();

    var $slide_upload = $("#slide-upload");
    var turtle_id = $slide_upload.data('turtle-id');
    // remove whole form element
    $slide_upload.remove();

    var $form = $("<form enctype='multipart/form-data' id='slide-upload-form'></form>");
    $form.append("<input type='file' name='slide-upload' id='slide-upload' class='slide-image-file' data-turtle-id='" + turtle_id + "'/>");
    $("#upload-modal .header h1").after("<input type='file' name='slide-upload' id='slide-upload' class='slide-image-file' data-turtle-id='" + turtle_id + "'/>");

    $("#modal-finish")
        .removeAttr('data-image-id')
        .removeAttr('disabled')
        .removeClass(".disable");

    // close modal box
    $("#modal-fade").hide();
    $("#upload-modal").hide().removeClass("wide");

    $portrait.hide();
    $landscape.hide();

    bindImageEvents();
}

function bindImageEvents(){
    $("#add-slide").off().on('click', function(e){
        e.preventDefault();

        //open modal window
        $("#modal-fade").show();
        $("#upload-modal").show();
    });

    $("#modal-fade").off().on('click', function(e){
        e.preventDefault();

        clearUploadModal();
    });

    $("#modal-finish").off().on('click', function(e){
        e.preventDefault();

        $(this).attr('disabled', 'disabled').addClass(".disable");

        var upload_path = getNormalizedUrl();
        upload_path += "slideshow/crop/";

        var turtle_id = $("#slide-upload").data('turtle-id');
        //get id
        var id = $(this).data('data-image-id');

        //spinner
        $('#finish-slide-uploading').animate({'opacity':100}, 200);

        var coordinates = {};
        //get portrait coordinates
        var portrait = {};
        portrait.x1 = $("#port_x1").val();
        portrait.y1 = $("#port_y1").val();
        portrait.x2 = $("#port_x2").val();
        portrait.y2 = $("#port_y2").val();
        coordinates.portrait = portrait;
        
        //get landscape coordinates
        var landscape = {};
        landscape.x1 = $("#land_x1").val();
        landscape.y1 = $("#land_y1").val();
        landscape.x2 = $("#land_x2").val();
        landscape.y2 = $("#land_y2").val();
        coordinates.landscape = landscape;

        // send info to server
        $.ajax({
            url : upload_path + turtle_id + "/" + id,
            type: 'POST',
            data: JSON.stringify(coordinates),
            success : function (response) {
                if(response){
                    // append the new slide to the slide sorter
                    $("#slide-sorter").append(createSlide(response));

                    //spinner
                    $('#finish-slide-uploading').animate({'opacity':0}, 200);

                    //clear modal
                    clearUploadModal();
                    bindImageEvents();
                }
            },
            error: function (response) {
                console.log("Slideshow image crop error: ");
                console.log(response);
            },
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        });

    });

    $(".turtle_image #slide-upload").off().on('change', function(e){
        e.preventDefault();

        //remove previous stuff if it was there
        $("#portrait").find(".content .image-container").empty();
        $("#landscape").find(".content .image-container").empty();

        var formData = new FormData($(this).parents('form')[0]);

        var upload_path = getNormalizedUrl();
        upload_path += "slideshow/upload/";

        var turtle_id = $(this).data('turtle-id');
        var id = Math.round((new Date()).getTime() / 1000) + "_" + Math.round(Math.random() * 10000);

        //spinner
        $('#slide-uploading').animate({'opacity':100}, 200);

        // upload image
        $.ajax({
            url : upload_path + turtle_id + "/" + id,
            type: 'POST',
            data: formData,
            success : function (response) {
            if(response){
                // add image to both portrait and landscape holder
                $("#portrait").find(".content .image-container").append("<img src='" + response.url + "' id='portrait-cropBox'/>");
                $("#landscape").find(".content .image-container").append("<img src='" + response.url + "' id='landscape-cropBox'/>");

                // activate jcrop for portrait
                $("#portrait-cropBox").Jcrop({
                    minSize: [960, 920],
                    maxSize: [960, 920],
                    setSelect: [0, 0, 960, 920],
                    trueSize:[response.width, response.height],
                    allowResize: false,
                    onChange:function(c){
                        $("#port_x1").val(c.x);
                        $("#port_y1").val(c.y);
                        $("#port_x2").val(c.x2);
                        $("#port_y2").val(c.y2);
                    }
                });

                // activate jcrop for landscape
                $("#landscape-cropBox").Jcrop({
                    minSize: [960, 920],
                    maxSize: [960, 920],
                    setSelect: [0, 0, 1920, 920],
                    trueSize:[response.width, response.height],
                    allowResize: false,
                    onChange:function(c){
                        $("#land_x1").val(c.x);
                        $("#land_y1").val(c.y);
                        $("#land_x2").val(c.x2);
                        $("#land_y2").val(c.y2);
                    }
                });

                //only show cropping viewport if images are bigger than max size
                if(response.height > 920){
                    $("#portrait").show();
                    $("#landscape").show();
                    $("#upload-modal").addClass("wide");
                }else if(response.width > 920){
                    $("#portrait").show();
                }else if(response.width > 1920){
                    $("#landscape").show();
                }

                //stop spinner
                $('#slide-uploading').animate({'opacity':0}, 200);
                // append id to finish button
                $("#modal-finish").data('data-image-id', id);
            }
        },
        error: function (response) {
            console.log("Slideshow image logo upload error: ");
            console.log(response);
        },
        //Options to tell JQuery not to process data or worry about content-type
        cache: false,
            contentType: false,
            processData: false
        });
    });

    $(".turtle_image .remove-slide").off().on('click', function(e){
        e.preventDefault();

        // thumb holder
        var holder = $(this).parent().parent();

        // turtle id
        var turtle_id = $("#slide-upload").data('turtle-id');

        // get image id
        var id = holder.data('id');

        var delete_path = getNormalizedUrl();
        delete_path += "slideshow/delete/";

        // ajax call to remove image from server
        $.ajax({
            url : delete_path + turtle_id + "/" + id,
            type: 'GET',
            success : function () {
                //remove thumb from DOM
                holder.remove();
            },
            error: function (response) {
                console.log("Slideshow slide delete error: ");
                console.log(response);
            },
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

bindImageEvents();
