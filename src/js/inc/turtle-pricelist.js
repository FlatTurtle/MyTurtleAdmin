/**
 * (Re)construct the price list from the given data
 */

function buildPriceList(data){
    var priceData = JSON.parse(data);
    if(priceData.categories){
        for(var i in priceData.categories){
            var category = priceData.categories[i];

            var categoryHTML = buildPriceListCategory(category.name)

            categoryHTML = buildPriceListCategoryEntries(category, categoryHTML);

            $('.categories').append(categoryHTML);
        }

        bindPriceListEvents();
    }
}


function buildPriceListCategory(name){
    if(typeof name === 'undefined'){
        name = "";
    }

    var control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" +  lang['turtle_pricelist_category_name'] + "</label>");

    var controls = $("<div class='controls'></div>");
    controls.append("<input type='text' class='input-small' placeholder='' value='" + name + "'/>");
    controls.append("<button id='add-category-entry' class='btn btn-small'>" + lang['turtle_pricelist_add_entry'] + "</button>");
    controls.append("<button id='delete-category' class='btn btn-small btn-warning pull-right'><i class='icon-trash'></i></button>");
    control_group.append(controls);

    var listings = $("<div class='listings'></div>");
    control_group.append(listings);

    control_group.append("<hr/>");

    return control_group;
}

function buildPriceListCategoryEntries(category, categoryHTML){
    if(category.entries){
        var listings = $(".listings", categoryHTML);
        var entries = category.entries;

        for(var i in entries){
            var name = entries[i].name;
            var description = entries[i].description;
            var price = entries[i].price;
            var image = entries[i].image;
            var id = entries[i].id;

            var item = buildPriceListCategoryEntry(name, description, price, image, id);
            listings.append(item);
        }
    }
}

function buildPriceListCategoryEntry(name, description, price, image, id){
    if(!name){
        name = "";
    }

    if(!description){
        description = "";
    }

    if(!price){
        price = 0.00;
    }

    if(!id){
        id = Math.round((new Date()).getTime() / 1000) + "_" + Math.round(Math.random() * 10000);
    }

    var entry_control = $("<div id='listing-" + id + "' class='listing'></div>");
    entry_control.append("<i class='icon-caret-right'></i>");
    entry_control.append("<input type='text' class='input' value='" + name + "'/>");

    entry_control.append("<input type='number' class='input' step='0.05' pattern='^\\d+(\\.|\\,)\\d{2}$' value='" + price + "'/>");
    entry_control.append("<button id='delete-item' class='btn btn-small'><i class='icon-trash'></i></button>");

    var buttonLabel = lang["term_upload"] + " " + lang["term_logo"].toLowerCase();
    if(image){
        buttonLabel = lang["term_change"] + " " + lang["term_logo"].toLowerCase();
    }

    var image_holder = $("<div class='entry_image_holder'></div>");
    var turtle_id = $('.turtle_pricelist').attr('id').split('_');

    var image_upload = $("<a class='btn small-file-upload btn-small' href='javascript:;'>" +
        "<span>" + buttonLabel + "</span>" +
        "<form enctype='multipart/form-data'>" +
        "<input type='file' name='file-"+id+"' class='pricelist-logo-file' data-turtle-id='"+ turtle_id[1] +"' data-id='"+ id + "'>" +
        "</form></a>");
    image_holder.append(image_upload);

    if(image){
        image_holder.append(buildPriceListImage(image, turtle_id[1], id));
    }
    entry_control.append(image_holder);

    // putting the description textarea on another line
    entry_control.append("<br/>");

    entry_control.append("<textarea rows='2' cols='35' class='styled'>" + description + "</textarea>");

    return entry_control;
}

function buildPriceListImage(image, turtle_id, id){
    var el = $('<span></span>');
    el.append("<img src='" + image + "' />");
    el.append("<a class='btn btn-small' href='#' data-turtle-id='"+ turtle_id +"' data-id='"+ id + "'>&times;</a> ");

    return el;
}

function savePriceList(){

}

function bindPriceListEvents(){

    // Add category button
    $(".turtle_pricelist #add-category").off().on('click', function(e){
        e.preventDefault();
        var pricelist_turtle = $(this).parents('.turtle_pricelist');

        var category_html = buildPriceListCategory();

        $(".categories", pricelist_turtle).append(category_html);
        bindPriceListEvents();
    });

    // Add category item
    $(".turtle_pricelist #add-category-entry").off().on('click', function(e){
        e.preventDefault();

        var control_group = $(this).parents('.control-group');
        var controls = buildPriceListCategoryEntry();

        $('.listings', control_group).append(controls);

        bindPriceListEvents();
    });

    // Remove category
    $(".turtle_pricelist #delete-category").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle_pricelist_delete_category_note'])){
            var component = $(this).parents('.control-group');
            component.remove();
        }
    });

    // Remove item entry
    $('.turtle_pricelist #delete-item').off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle_pricelist_delete_item_note'])){
            var component = $(this).parents('.listing');
            component.remove();
        }
    });
}

bindPriceListEvents();
