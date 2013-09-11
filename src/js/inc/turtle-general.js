/**
 * Pane switcher for left side of the screen
 */
var current_pane_id = 0;

$('#pane-selector li').on('click', function(e){
    var selected = $(this).attr('id').split('_')[1];
    if(!$(this).hasClass('active')){
        $('#pane-selector li').removeClass('active');
        $(this).addClass('active');
        $('.turtle-area').fadeOut(0);
        $('#pane_' + selected).fadeIn();
        current_pane_id = selected;
    }
});


/**
 * Bind events to (new) turtles
 */
function bind_event_to_turtles(){

    // Autocomplete De Lijn
    $(".delijn-location").off().on('keydown.autocomplete', function(){
        $(this).autocomplete({
            minLength: 4,
            source: function( request, response ) {
                $.ajax({
                    url: "https://data.irail.be/DeLijn/Stations.json",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        name: request.term
                    },
                    success: function( data ) {
                        if(data.Stations){
                            // Filter duplicates
                            var stations = {};
                            for(var i in data.Stations){
                                var station = data.Stations[i].name.camelcase();
                                stations[station] = true;
                            }

                            response( $.map( stations, function(value, key) {
                                return {
                                    label: key,
                                    value: key
                                }
                            }));
                        }
                    }
                });
            }
        });
    });

    // Autocomplete NMBS
    $(".nmbs-location").off().on('keydown.autocomplete', function(){
        $(this).autocomplete({
            minLength: 3,
            source: function( request, response ) {
                $.ajax({
                    url: "https://data.irail.be/NMBS/Stations.json",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        name: request.term
                    },
                    success: function( data ) {
                        var pattern = new RegExp(request.term.toLowerCase());
                        response( $.map( data.Stations, function( item ) {
                            if(item.name.toLowerCase().match(pattern)){
                                return {
                                    label: item.name,
                                    value: item.name
                                }
                            }
                        }));
                    }
                });
            }
        });
    });

    // Autocomplete MIVB
    $(".mivb-location").off().on('keydown.autocomplete', function(){
        $(this).autocomplete({
            minLength: 3,
            source: function( request, response ) {
                $.ajax({
                    url: "https://data.irail.be/MIVBSTIB/Stations.json",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        name: request.term
                    },
                    success: function( data ) {
                        if(data.Stations){
                            // Filter duplicates
                            var stations = {};
                            for(var i in data.Stations){
                                var station = data.Stations[i].name.camelcase();
                                stations[station] = true;
                            }

                            response( $.map( stations, function(value, key) {
                                return {
                                    label: key,
                                    value: key
                                }
                            }));
                        }
                    }
                });
            }
        });
    });


    // Autocomplete Velo
    $(".velo-name").off().on('keydown.autocomplete', function(){
        var self = $(this);
        $(this).autocomplete({
            minLength: 3,
            autoFocus: true,
            autoSelect: true,
            source: function( request, response ) {
                $.ajax({
                    url: "https://data.irail.be/Bikes/Velo.json",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        name: request.term
                    },
                    success: function( data ) {
                        var pattern = new RegExp(request.term.toLowerCase());
                        response( $.map( data.Velo, function( item ) {
                            if(item.name.toLowerCase().match(pattern)){
                                return {
                                    label: item.name,
                                    value: item.name,
                                    location: item.latitude + ',' + item.longitude
                                }
                            }
                        }));
                    }
                });
            },
            select: function(e, ui){
                $('.velo-location',self.parents('.turtle_instance')).val(ui.item.location);
            },
            change: function(e, ui){
                if ( !ui.item ) {
                    self.val('');
                }
            }
        });
    });

    // Autocomplete Villo
    $(".villo-name").off().on('keydown.autocomplete', function(){
        var self = $(this);
        $(this).autocomplete({
            minLength: 3,
            autoFocus: true,
            autoSelect: true,
            source: function( request, response ) {
                $.ajax({
                    url: "https://data.irail.be/Bikes/Villo.json",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        name: request.term
                    },
                    success: function( data ) {
                        var pattern = new RegExp(request.term.toLowerCase());
                        response( $.map( data.Villo, function( item ) {
                            item.name = item.name.toLowerCase();
                            var name = item.name.match(/^[0-9]+\s*-\s*((.*?)(?:[\/|:](.*))?)$/);
                            console.log(name);
                            if(name[1].match(pattern)){
                                return {
                                    label: name[1].camelcase(),
                                    value: name[1].camelcase(),
                                    location: item.latitude + ',' + item.longitude
                                }
                            }
                        }));
                    }
                });
            },
            select: function(e, ui){
                $('.villo-location',self.parents('.turtle_instance')).val(ui.item.location);
            },
            change: function(e, ui){
                if ( !ui.item ) {
                    self.val('');
                }
            }
        });
    });

    // Collapsable turtles
    $('.turtle_instance .title').off().on('click',function(){
        try{$('.autocomplete').autocomplete('close');}catch(e){}
        $('.edit_area', $(this).parent()).slideToggle(200);
    });

    // Save turtle options
    $('.turtle_instance form').off().on('submit',function(e){
        e.preventDefault();
        $('.turtle_save', $(this)).click();
    });
    $('.turtle_instance .turtle_save').off().on('click',function(e){
        e.preventDefault();
        $(this).focus();
        var turtle_instance = $(this).parents('.turtle_instance');
        var button = $(this);

        if(button.attr('disabled') != 'disabled'){
            button.attr('disabled', 'disabled').addClass('disable');
            $('.loading', turtle_instance).animate({'opacity': 1}, 200);

            var turtle_id = turtle_instance.attr('id').split('_')[1];
            var option_data = new Object();
            var inputs = $('form :input',turtle_instance);
            inputs.each(function(){
                if($(this).attr('name')){
                    var option_name = $(this).attr('name').split(turtle_id + '-')[1];
                    if(option_name){
                        option_data[option_name] = $(this).val();
                    }
                }
            });

            // Resolve MapBox location to geocode first
            if(turtle_instance.hasClass('turtle_mapbox') && option_data['name'] != ""){
                $.ajax({
                    url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+ encodeURIComponent(option_data['name']) +'&sensor=false',
                    type: 'GET',
                    success: function( data ) {
                        if(data.results.length > 0){
                            var geocode_el = data.results[0].geometry.location;
                            if(typeof geocode_el !='undefined'){
                                option_data['location'] = geocode_el.lat + "," + geocode_el.lng;
                                updateTurtle(turtle_instance, button, turtle_id, option_data);
                            }
                        }else{
                            alert(lang['error_resolve_address']);
                            $('.loading', turtle_instance).animate({'opacity':0}, 200);
                            button.removeAttr('disabled').removeClass('disable');
                        }
                    },
                    error: function(data, status){
                        alert(lang['error_resolve_address']);
                        $('.loading', turtle_instance).animate({'opacity':0}, 200);
                        button.removeAttr('disabled').removeClass('disable');
                    }
                });
            }else if((turtle_instance.hasClass('turtle_villo') | turtle_instance.hasClass('turtle_velo')) && option_data['location'] != ""){
                // Resolve and save walking time for villo and velo turtles
                calculateWalkTime(option_data['location'], turtle_instance, button, turtle_id, option_data);
            }else if(turtle_instance.hasClass('turtle_nmbs') && option_data['location'] != ""){
                // Resolve and save walking time for nmbs
                $.ajax({
                    url: 'http://data.irail.be/NMBS/Stations.json',
                    type: 'GET',
                    success: function( data ) {
                        var pattern = new RegExp(option_data['location'].toLowerCase());
                        var found = null
                        $.map( data.Stations, function( item ) {
                            if(item.name.toLowerCase().match(pattern)){
                                found = item.latitude + "," + item.longitude;
                            }
                        });

                        if(found != null){
                            calculateWalkTime(found, turtle_instance, button, turtle_id, option_data);
                        }else{
                            option_data['time_walk'] = -1;
                            updateTurtle(turtle_instance, button, turtle_id, option_data);
                        }
                    },
                    error: function(data, status){
                        option_data['time_walk'] = -1;
                        updateTurtle(turtle_instance, button, turtle_id, option_data);
                    }
                });
            }else if(turtle_instance.hasClass('turtle_delijn') && option_data['location'] != ""){
                // Resolve and save walking time for delijn
                $.ajax({
                    url: 'http://data.irail.be/DeLijn/Stations.json',
                    type: 'GET',
                    dataType: "json",
                    data: {
                        name: option_data['location'].toLowerCase()
                    },
                    success: function( data ) {
                        var pattern = new RegExp(option_data['location'].toLowerCase());
                        var found = null
                        $.map( data.Stations, function( item ) {
                            if(item.name.toLowerCase().match(pattern)){
                                found = item.latitude + "," + item.longitude;
                            }
                        });

                        if(found != null){
                            calculateWalkTime(found, turtle_instance, button, turtle_id, option_data);
                        }else{
                            option_data['time_walk'] = -1;
                            updateTurtle(turtle_instance, button, turtle_id, option_data);
                        }
                    },
                    error: function(data, status){
                        option_data['time_walk'] = -1;
                        updateTurtle(turtle_instance, button, turtle_id, option_data);
                    }
                });
            }else if(turtle_instance.hasClass('turtle_mivb') && option_data['location'] != ""){
                // Resolve and save walking time for nmbs
                $.ajax({
                    url: "http://data.irail.be/MIVBSTIB/Stations.json",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        name: option_data['location'].toLowerCase()
                    },
                    success: function( data ) {
                        var pattern = new RegExp(option_data['location'].toLowerCase());
                        var found = null
                        $.map( data.Stations, function( item ) {
                            if(item.name.toLowerCase().match(pattern)){
                                found = item.latitude + "," + item.longitude;
                            }
                        });

                        if(found != null){
                            calculateWalkTime(found, turtle_instance, button, turtle_id, option_data);
                        }else{
                            option_data['time_walk'] = -1;
                            updateTurtle(turtle_instance, button, turtle_id, option_data);
                        }
                    },
                    error: function(data, status){
                        option_data['time_walk'] = -1;
                        updateTurtle(turtle_instance, button, turtle_id, option_data);
                    }
                });
            }else if(turtle_instance.hasClass('turtle_rss') && option_data['feed'] != ""){
                // Add http:// in front of RSS feed when it's missing
                var httpDetectRegExp = new RegExp('^http(s?)://');
                if(!httpDetectRegExp.test(option_data['feed'])){
                    option_data['feed'] = "http://" + option_data['feed'];
                }
                updateTurtle(turtle_instance, button, turtle_id, option_data);
            }else if(turtle_instance.hasClass('turtle_signage')){
                option_data['data'] = saveSignage();
                updateTurtle(turtle_instance, button, turtle_id, option_data);
            }else if(turtle_instance.hasClass('turtle_pricelist')){
                option_data['data'] = savePriceList();
                updateTurtle(turtle_instance, button, turtle_id, option_data);
            }else{
                updateTurtle(turtle_instance, button, turtle_id, option_data);
            }
        }
    });

    // Delete turtles
    $('.turtle_instance .delete').off().on('click',function(e){
        e.preventDefault();
        if(confirm(lang['turtle_delete_note'])){
            var turtle_instance = $(this).parents('.turtle_instance');
            var turtle_id = turtle_instance.attr('id').split('_')[1];

            $(this).off();
            $.ajax({
                url: pathname + '/delete',
                type: 'POST',
                data: {
                    id: turtle_id
                },
                success: function( data ) {
                    turtle_instance.slideUp(300, function(){
                        turtle_instance.remove();
                    });
                },
                error: function(data, status){
                    alert(lang['error_delete_turtle'] + ": " + status);
                }
            });
        }
    });

    // RSS type selector
    $('.turtle_rss .rss-feed-type').off().on('change', function(e){
        var turtle =  $(e.target).parents('.turtle_rss');
        var value = $(e.target).val();
        if(value == 'custom'){
            $('.rss-feed', turtle).val('').fadeIn();
        }else{
            $('.rss-feed', turtle).hide().val(value);
        }
    });

    // Twitter larger selector
    $('.turtle_instance .make-larger').off().on('click', function(){
        $('.turtle_instance .size-field').val('');
        if($(this).is(':checked')){
            $('.turtle_instance .size-field').val('big');
        }
    });

    // Map & mapbox type selector
    $('.turtle_map .map-location-type').off().on('change', changedMapType);
    $('.turtle_mapbox .map-location-type').off().on('change', changedMapType);
}


// Check Twitter options default
if($('.turtle_instance .size-field').val() == "big"){
    $('.turtle_instance .make-larger').attr('checked', 'checked')
}


/**
 * Calculate walking distance between screen and (new) location
 */
function calculateWalkTime(to, turtle_instance, button, turtle_id, option_data){
    // Is the screen location set?
    if(from && from.hasOwnProperty('lat') && from.hasOwnProperty('lon')){

        // Get results with AJAX
        $.ajax({
            url: 'https://data.flatturtle.com/Geo/Distance/'+ from.lat + ',' + from.lon +'/'+to+'.json',
            type: 'GET',
            success: function( data ) {
                if(data.Distance.rows[0].elements[0].duration != null){
                    var distance_el = data.Distance.rows[0].elements[0].duration;
                    if(typeof distance_el !='undefined'){
                        option_data['time_walk'] = distance_el.value / 60;
                        updateTurtle(turtle_instance, button, turtle_id, option_data);
                    }
                }else{
                    alert(lang['error_resolve_time_walk']);
                    option_data['time_walk'] = -1;
                    updateTurtle(turtle_instance, button, turtle_id, option_data);
                }
            },
            error: function(data, status){
                alert(lang['error_resolve_time_walk']);
                option_data['time_walk'] = -1;
                updateTurtle(turtle_instance, button, turtle_id, option_data);
            }
        });
    }
}


function changedMapType(e){
    var turtle =  $(e.target).parents('.turtle_instance');
    var value = $(e.target).val();
    console.log('j');
    if(value == 'custom'){
        $('.location', turtle).val('').fadeIn();
    }else{
        $('.location', turtle).hide().val('');
    }
}

// Turtle update ajax request
function updateTurtle(turtle_instance, button, turtle_id, option_data){
    var path = pathname;
    var split = pathname.split("right");
    if(split.length > 1){
        path = split[0] + "left";
    }

    $.ajax({
        url: path + '/update',
        type: 'POST',
        data: {
            id: turtle_id,
            options: option_data
        },
        success: function( data ) {
            $('.loading', turtle_instance).animate({'opacity':0}, 200);
            button.removeAttr('disabled').removeClass('disable');
        },
        error: function(data, status){
            alert(lang['error_save'] + ": " + status);
            $('.loading', turtle_instance).animate({'opacity':0}, 200);
            button.removeAttr('disabled').removeClass('disable');
        }
    });
}


// Bind events for existing turtles
bind_event_to_turtles();