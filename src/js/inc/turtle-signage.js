/**
 * Build signage turtle
 */
function buildSignage(data){
    var signage_data = JSON.parse(data);
    if(signage_data){
        for(i in signage_data){
            var location = signage_data[i].location;

            // Contains all the floors HTML
            var control_group = $("<div class='control-group'></div>");
            control_group.append("<label class='control-label'>" +  lang['turtle.signage_floor_location'] + "</label>");

            // Container for the floor name and buttons
            var controls = $("<div class='controls'></div>");
            controls.append("<input type='text' class='input-small location' value='" + location + "' placeholder=''/>");
            controls.append("<button id='add-floor-item' class='btn btn-small'>" + lang['turtle.signage_add_floor_listing'] + "</button>");
            controls.append("<button id='delete-floor' class='btn btn-small btn-warning pull-right'><i class='icon-trash'></i></button>");
            control_group.append(controls);

            // Container for the floor items and item buttons
            var listings = $("<div class='listings'></div>");
            if(signage_data[i].floors){
                var floors = signage_data[i].floors;
                for(j in floors){
                    var listing_controls = $("<div class='controls listing'></div>");
                    listing_controls.append("<i class='icon-caret-right'></i>");
                    listing_controls.append("<input type='text' placeholder='' class='input' value='" + floors[j].name + "'/>");
                    listing_controls.append("<button class='btn btn-small delete-floor-item'><i class='icon-trash'></i></button>");

                    listings.append(listing_controls);
                }
            }
            control_group.append(listings);

            // Trailing HR
            control_group.append("<hr/>");

            $('.floors').append(control_group);
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

            if(listing.name.length > 0)
                floor.floors.push(listing);
        });
        signage_data.push(floor);
    });

    return JSON.stringify(signage_data);
}


/**
 * Bind events to buttons on signage
 */
function bindSignageEvents(){
    // Add a floor button
    $(".turtle_signage #add-floor").off().on('click', function(e){
        e.preventDefault();
        var turtle_signage = $(this).parents('.turtle_signage');

        // Contains all the floors HTML
        var control_group = $("<div class='control-group'></div>");
        control_group.append("<label class='control-label'>" +  lang['turtle.signage_floor_location'] + "</label>");

        // Container for the floor name and buttons
        var controls = $("<div class='controls'></div>");
        controls.append("<input type='text' class='input-small location' value='' placeholder=''/>");
        controls.append("<button id='add-floor-item' class='btn btn-small'>" + lang['turtle.signage_add_floor_listing'] + "</button>");
        controls.append("<button id='delete-floor' class='btn btn-small btn-warning pull-right'><i class='icon-trash'></i></button>");
        control_group.append(controls);

        // Container for the floor items and item buttons
        var listings = $("<div class='listings'></div>");
        control_group.append(listings);

        // Trailing HR
        control_group.append("<hr/>");


        $('.floors', turtle_signage).append(control_group);
        bindSignageEvents();
    });

    // Add an item on a floor
    $(".turtle_signage #add-floor-item").off().on('click', function(e){
        e.preventDefault();

        var floor_group = $(this).parents('.control-group');

        var listing_controls = $("<div class='controls listing'></div>");
        listing_controls.append("<i class='icon-caret-right'></i>");
        listing_controls.append("<input type='text' placeholder='' class='input' value=''/>");
        listing_controls.append("<button class='btn btn-small delete-floor-item'><i class='icon-trash'></i></button>");

        $('.listings', floor_group).append(listing_controls);
        bindSignageEvents();
    });

    // Delete a floor
    $(".turtle_signage #delete-floor").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle.signage_delete_floor_note'])){
            $(this).parents('.control-group').remove();
        }

    });

    // Delete floor item
    $(".turtle_signage .delete-floor-item").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle.signage_delete_entry_note'])){
            $(this).parents('.listing').remove();
        }

    });
}
bindSignageEvents();