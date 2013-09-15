/**
 *
 * Construct the menu from existing data
 */

function buildWeekMenu(data){
    var menu_data = JSON.parse(data);

    if(menu_data.categories){

        for(var i in menu_data.categories){
            var category = menu_data.categories[i];

            var category_html = buildWeekMenuCategory(category.name, category.price);

            category_html = buildWeekMenuCategoryEntries(category, category_html);

            $('.turtle_weekmenu .categories').append(category_html);
        }
        bindWeekMenuEvents();
    }

    if(menu_data.offers){

        for(var i in menu_data.offers){
            var offer = menu_data.offers[i];

            var offer_html = buildWeekMenuOffer(offer.name, offer.description, offer.price, offer.image, offer.id);

            $('.turtle_weekmenu .offers').append(offer_html);
        }
        bindWeekMenuEvents();
    }
}

function buildWeekMenuCategory(name, price){
    if(typeof name === 'undefined'){
        name = "";
    }

    if(typeof price === 'undefined'){
        price = 0;
    }

    var container = $("<div class='category'></div>");

    var control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" + lang['turtle_pricelist_category_name'] + "</label> ");
    var controls = $("<div class='controls'></div>");

    controls.append("<input type='text' class='input-small name' placeholder='' value='" + name + "'/>");
    controls.append("<button id='delete-category' class='btn btn-small btn-warning pull-right'><i class='icon-trash'></i></button>");
    control_group.append(controls);

    container.append(control_group);

    //building next control group
    control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" + lang['term_price'] + "</label>");
    controls = $("<div class='controls'></div>");
    controls.append("<input type='number' class='input price' step='0.05' pattern='^\\d+(\\.|\\,)\\d{2}$' value='" + price + "'/>");
    control_group.append(controls);
    container.append(control_group);

    control_group = $("<div class='control-group'></div>");
    var listings = $("<div class='listings'></div>");
    control_group.append(listings);
    control_group.append("<hr/>");

    container.append(control_group);
    return container;
}

function buildWeekMenuCategoryEntries(category, category_html){
    var entries = [];

    if(category.meals){
        entries = category.meals;
        var listings = $('.listings', category_html);
        var days = ["term_monday", "term_tuesday", "term_wednesday", "term_thursday", "term_friday"];
        for(var i in days){
            var entry = entries[i];
            var name_of_day = lang[days[i]];
            var item = buildWeekMenuCategoryEntry(name_of_day, entry.name, entry.image, entry.id);

            listings.append(item);
        }
    }

    return category_html;
}

function buildWeekMenuCategoryEntry(name_of_day, name, image, id){
    if(!name){
        name = "";
    }

    if(!id){
        id = Math.round((new Date()).getTime() / 1000) + "_" + Math.round(Math.random() * 10000);
    }

    var entry_control = $("<div id='listing-" + id + "' class='listing control-group'></div>");
    entry_control.append("<label class='control-label'>" + name_of_day + "</label> ");
    var controls = $("<div class='controls'></div>");
    controls.append("<input type='text' class='input name' value='" + name + "'/>");

    var buttonLabel = lang["term_upload"] + " " + lang["term_image"].toLowerCase();
    if(image){
        buttonLabel = lang["term_change"] + " " + lang["term_image"].toLowerCase();
    }

    var image_holder = $("<div class='entry_image_holder'></div>");
    var turtle_id = $('.turtle_pricelist').attr('id').split('_');

    var image_upload = $("<a class='btn small-file-upload btn-small' href='javascript:;'>" +
        "<span>" + buttonLabel + "</span>" +
        "<form enctype='multipart/form-data'>" +
        "<input type='file' name='file-"+id+"' class='pricelist-image-file' data-turtle-id='"+ turtle_id[1] +"' data-id='"+ id + "'>" +
        "</form></a>");
    image_holder.append(image_upload);

    if(image){
        image_holder.append(buildPriceListImage(image, turtle_id[1], id));
    }
    controls.append(image_holder);

    entry_control.append(controls);

    return entry_control;
}

function buildWeekMenuOffer(name, description, price, image, id){
    if(!name){
        name = "";
    }

    if(!description){
        description = "";
    }

    if(!price){
        price = 0.00;
    }

    if(!image){
        image = "";
    }

    if(!id){
        id = Math.round((new Date()).getTime() / 1000) + "_" + Math.round(Math.random() * 10000);
    }

    var container = $("<div id='offer-" + id + "' class='offer'></div>");

    // name
    var control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" + lang['turtle_weekmenu_offer_name'] + "</label> ");
    var controls = $("<div class='controls'></div>");
    controls.append("<input type='text' class='input name' value='" + name + "'/>");
    controls.append("<button id='delete-offer' class='btn btn-small btn-warning pull-right'><i class='icon-trash'></i></button>");
    control_group.append(controls);
    container.append(control_group);

    // price
    control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" + lang['term_price'] + "</label> ");
    controls = $("<div class='controls'></div>");
    controls.append("<input type='number' class='input price' step='0.05' pattern='^\\d+(\\.|\\,)\\d{2}$' value='" + price + "'/>");
    control_group.append(controls);
    container.append(control_group);

    //image upload
    control_group = $("<div class='control-group'></div>");
    controls = $("<div class='controls'></div>");
    var buttonLabel = lang["term_upload"] + " " + lang["term_image"].toLowerCase();
    if(image){
        buttonLabel = lang["term_change"] + " " + lang["term_image"].toLowerCase();
    }

    var image_holder = $("<div class='entry_image_holder'></div>");
    var turtle_id = $('.turtle_pricelist').attr('id').split('_');

    var image_upload = $("<a class='btn small-file-upload btn-small' href='javascript:;'>" +
        "<span>" + buttonLabel + "</span>" +
        "<form enctype='multipart/form-data'>" +
        "<input type='file' name='file-"+id+"' class='pricelist-image-file' data-turtle-id='"+ turtle_id[1] +"' data-id='"+ id + "'>" +
        "</form></a>");
    image_holder.append(image_upload);

    if(image){
        image_holder.append(buildPriceListImage(image, turtle_id[1], id));
    }
    controls.append(image_holder);
    control_group.append(controls);
    container.append(control_group);

    control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" + lang['term_description'] + "</label> ");
    controls = $("<div class='controls'></div>");
    controls.append("<textarea rows='2' cols='35' class='styled description'>" + description + "</textarea>");
    control_group.append(controls);
    control_group.append("<hr/>");
    container.append(control_group);

    return container;
}

function bindWeekMenuEvents(){
    // bind 'add category' button
    $(".turtle_weekmenu #add-category").off().on('click', function(e){
        e.preventDefault();

        var turtle =  $(this).parents('.turtle_weekmenu');

        var category_html = buildWeekMenuCategory();

        var days = ["term_monday", "term_tuesday", "term_wednesday", "term_thursday", "term_friday"];
        for(var i in days){
            var name_of_day = lang[days[i]];
            $('.listings', category_html).append(buildWeekMenuCategoryEntry(name_of_day));
        }

        $(".categories", turtle).append(category_html);
        bindWeekMenuEvents();
    });

    // bind 'delete category' button
    $(".turtle_weekmenu #delete-category").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle_weekmenu_delete_category_note'])){
            var component = $(this).parents('.category');

            // Remove images
            $('.weekmenu_image_delete', component).click();

            component.remove();
        }
    });

    // bind 'add offer' button
    $(".turtle_weekmenu #add-offer").off().on('click', function(e){
        e.preventDefault();

        var turtle =  $(this).parents('.turtle_weekmenu');

        var offer_html = buildWeekMenuOffer();

        $(".offers", turtle).append(offer_html);
        bindWeekMenuEvents();
    });

    $(".turtle_weekmenu #delete-offer").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle_weekmenu_delete_offer_note'])){
            var component = $(this).parents('.offer');

            // Remove images
            $('.weekmenu_image_delete', component).click();

            component.remove();
        }
    });
}

function saveWeekMenu(){
    var data = {};

    // get categories and their meals
    data.categories = [];
    $('.categories .category').each(function(){
        var category = {};

        category.name = $('.name', this).val();
        category.price = $('.price', this).val();

        // get meals
        category.meals = [];
        $('.listing', this).each(function(){
            var meal = {};
            meal.name = $('.name', this).val();

            // Save id
            var id = $(this).prop('id').split('-');
            meal.id = id[1];

            //save image url
            if($(this).has('img')){
                meal.image = $('img', $(this)).attr('src');
            }

            if(meal.name.length > 0){
                category.meals.push(meal);
            }
        });

        data.categories.push(category);
    });

    // get offers
    data.offers = [];
    $('.offers .offer').each(function(){
        var offer = {};

        offer.name = $('.name', this).val();
        offer.description = $('.description', this).val();
        offer.price = $('.price', this).val();

        // save id
        var id = $(this).prop('id').split('-');
        offer.id = id[1];

        //save image url
        if($(this).has('img')){
            offer.image = $('img', $(this)).attr('src');
        }

        if(offer.name.length > 0){
            data.offers.push(offer);
        }
    });

    console.log(data);
    return JSON.stringify(data);
}

bindWeekMenuEvents();