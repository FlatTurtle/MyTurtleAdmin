/**
 * Build signage turtle
 */
function buildSignage(data){
    var signage_data = JSON.parse(data);
    if(signage_data){
        for(i in signage_data){
            var location = signage_data[i].location;

            // Create a new floor
            var floor_html = makeSignageFloor(location, id);
            var listings = $('.listings', floor_html);

            if(signage_data[i].floors){
                var floors = signage_data[i].floors;
                for(j in floors){
                    var name = floors[j].name;
                    if(typeof name === 'undefined')
                        name = '';


                    var id = floors[j].id;
                    var logo = floors[j].logo;

                    // Add floor item
                    var listing_controls = makeSignageFloorItem(name, id, logo);
                    listings.append(listing_controls);
                }
            }

            $('.floors').append(floor_html);
        }

        bindSignageEvents();
    }
}

/**
 * Get JSON to save
 */
function saveSignage(){
    // Construct data to be pushed as option
    var signage_data = [];
    $('.floors .control-group').each(function(){
        var floor = new Object();
        // Get floor name
        floor.location = $(".location", this).val();
        floor.floors = [];

        //Get individual listing
        $(".listing", this).each(function(){
            var listing = new Object();
            listing.name = $('input', this).val();

            // Save id
            var id = $(this).prop('id').split('-');
            listing.id = id[1];

            // Save logo when there is one
            if($(this).has('img')){
                listing.image = $('img', $(this)).attr('src');
            }

            if(listing.name.length > 0)
                floor.floors.push(listing);
        });
        signage_data.push(floor);
    });

    return JSON.stringify(signage_data);
}

/**
 * Create a floor HTML structure
 */
function makeSignageFloor(location){
    if(!location){
        location = "";
    }

    // Contains all the floors HTML
    var control_group = $("<div class='control-group floor'></div>");
    control_group.append("<label class='control-label'>" +  lang['turtle.signage_floor_location'] + "</label>");

    // Container for the floor name and buttons
    var controls = $("<div class='controls'></div>");
    controls.append("<input type='text' class='input-small location' value='" + location + "' placeholder=''/>");
    controls.append("<button id='add-floor-item' class='btn btn-small'>" + lang['turtle.signage_add_floor_listing'] + "</button>");
    controls.append("<button id='delete-floor' class='btn btn-small btn-warning pull-right'><i class='icon-trash'></i></button>");
    control_group.append(controls);

    // Container for the floor items and item buttons
    var listings = $("<div class='listings'></div>");
    control_group.append(listings);

    // Trailing HR
    control_group.append("<hr/>");

    return control_group;
}

/**
 * Create a floor item
 */
function makeSignageFloorItem(name, id, logo){
    if(!name){
        name = "";
    }

    if(!id){
        // Create a random id (new item)
        id = Math.round((new Date()).getTime() / 1000) + "_" +  Math.round(Math.random() * 10000);
    }

    var listing_controls = $("<div id='listing-" + id + "' class='listing'></div>");
    listing_controls.append("<i class='icon-caret-right'></i>");
    listing_controls.append("<input type='text' placeholder='' class='input' value='" + name + "'/>");
    listing_controls.append("<button class='btn btn-small delete-floor-item'><i class='icon-trash'></i></button>");


    var buttonLabel = lang["term.upload"] + " " + lang["term.logo"].toLowerCase();
    if(logo){
        buttonLabel = lang["term.change"] + " " + lang["term.logo"].toLowerCase();
    }

    var logo_holder = $("<div class='floor_logo_holder'></div>");
    var turtle_id = $('.turtle_signage').attr('id').split('_');

    var image_upload = $("<a class='btn small-file-upload btn-small' href='javascript:;'><span>"  + buttonLabel + "</span><form enctype='multipart/form-data'><input type='file' name='file-"+id+"' class='signage_logo_file' data-turtle-id='"+ turtle_id[1] +"' data-id='"+ id + "'></form></a>");
    logo_holder.append(image_upload);

    if(logo){
        logo_holder.append(makeSignageLogoItem(logo, turtle_id[1], id));
    }
    listing_controls.append(logo_holder);

    return listing_controls;
}

/**
 * Create image components for signage logo
 */
function makeSignageLogoItem(logo, turtle_id, id){
    var el = $('<span></span>');
    el.append('<img src="' + logo + '"/>');
    el.append("<a class='btn btn-small signage_logo_delete' href='#' data-turtle-id='"+ turtle_id +"' data-id='"+ id + "'>&times;</a>");

    return el;
}


/**
 * Bind events to buttons on signage
 */
function bindSignageEvents(){

    // Add a floor button
    $(".turtle_signage #add-floor").off().on('click', function(e){
        e.preventDefault();
        var turtle_signage = $(this).parents('.turtle_signage');

        var floor_html = makeSignageFloor();

        $('.floors', turtle_signage).append(floor_html);
        bindSignageEvents();
    });

    // Add an item on a floor
    $(".turtle_signage #add-floor-item").off().on('click', function(e){
        e.preventDefault();

        var floor_group = $(this).parents('.control-group');
        var listing_controls = makeSignageFloorItem();

        $('.listings', floor_group).append(listing_controls);
        bindSignageEvents();
    });

    // Delete a floor
    $(".turtle_signage #delete-floor").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle.signage_delete_floor_note'])){
            var component = $(this).parents('.control-group');

            // Remove logos
            $('.signage_logo_delete', component).click();

            component.remove();
        }

    });

    // Delete floor item
    $(".turtle_signage .delete-floor-item").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle.signage_delete_entry_note'])){
            var listing = $(this).parents('.listing');

            // Remove logos
            $('.signage_logo_delete', listing).click();

            listing.remove();
        }

    });

    // Logo upload
    $('.signage_logo_file').off().on('change', function(e){
        e.preventDefault();

        var formData = new FormData($(this).parents('form')[0]);
        var button = $(this).parents(".small-file-upload");
        var buttonLabel = $('span', button);
        var inputFileEl = $(this);


        if(!button.hasClass('disabled')){
            buttonLabel.html(lang['term.uploading'] + " ...");
            inputFileEl.attr('disabled', 'disabled');
            button.attr('disabled', 'disabled').addClass('disable');


            var signage_upload_path = pathname;
            var split = pathname.split("right");
            if(split.length > 1){
                signage_upload_path = split[0];
            }
            signage_upload_path += "signage/upload/";

            var turtle_id = $(this).data('turtle-id');
            var id = $(this).data('id');
            var turtle_logo_holder = $(this).parents(".floor_logo_holder");

            $.ajax({
                url : signage_upload_path + turtle_id + "/" + id,
                type: 'POST',
                data: formData,
                success : function (response) {
                    if(response){
                        button.removeAttr('disabled').removeClass('disable');
                        inputFileEl.removeAttr('disabled');
                        buttonLabel.html(lang["term.change"] + " " + lang["term.logo"].toLowerCase());

                        turtle_logo_holder.append(makeSignageLogoItem(response, turtle_id, id));
                        bindSignageEvents();
                    }else{
                        button.removeAttr('disabled').removeClass('disable');
                        inputFileEl.removeAttr('disabled');
                        buttonLabel.html(lang["term.upload"] + " " + lang["term.logo"].toLowerCase());
                    }
                },
                error: function (response) {
                    console.log("Signage logo upload error: ");
                    console.log(response);
                    button.removeAttr('disabled').removeClass('disable');
                    inputFileEl.removeAttr('disabled');
                    buttonLabel.html(lang["term.upload"] + " " + lang["term.logo"].toLowerCase());
                },
                //Options to tell JQuery not to process data or worry about content-type
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });


    // Logo delete
    $('.signage_logo_delete').off().on('click', function(e){
        e.preventDefault();
        var signage_delete_path = pathname;
        var split = pathname.split("right");
        if(split.length > 1){
            signage_delete_path = split[0];
        }
        signage_delete_path += "signage/delete/";

        var turtle_id = $(this).data('turtle-id');
        var id = $(this).data('id');
        var turtle_logo_holder = $(this).parents(".floor_logo_holder");
        var button = $(".small-file-upload", turtle_logo_holder);
        var buttonLabel = $('span', button);

        $.ajax({
            url : signage_delete_path + turtle_id + "/" + id,
            type: 'GET',
            success : function (response) {
                $('img',turtle_logo_holder).remove();
                $('.signage_logo_delete',turtle_logo_holder).remove();
                buttonLabel.html(lang["term.upload"] + " " + lang["term.logo"].toLowerCase());
            },
            error: function (response) {
                console.log("Signage logo delete error: ");
                console.log(response);
            },
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        });
    });
}
bindSignageEvents();