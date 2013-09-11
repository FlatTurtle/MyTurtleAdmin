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
    controls.append("<input type='text' class='input-small' value='" + name + "' placeholder=''/>");
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
            if(typeof name === 'undefined'){
                name = '';
            }

            var description = entries[i].description;
            if(typeof description === 'undefined'){
                description = '';
            }

            var price = entries[i].price;
            var image = entries[i].image;

            var item = buildPriceListCategoryEntry(name, description, price, image);
            listings.append(item);
        }
    }
}

function buildPriceListCategoryEntry(name, description, price, image){
    if(!name){
        name = "";
    }

    if(description){
        description = "";
    }

    if(price){
        price = 0;
    }

    var entry_control = $("<div class='listing' ></div>");
    entry_control.append("<i class='icon-caret-right'></i>");
    entry_control.append("<input type='text' placeholder='' class='input' value='" + name + "'/>");
    entry_control.append("<button id='delete-item' class='btn btn-small'><i class='icon-trash'></i></button>");

    var buttonLabel = lang["term_upload"] + " " + lang["term_logo"].toLowerCase();
    if(image){
        buttonLabel = lang["term_change"] + " " + lang["term_logo"].toLowerCase();
    }

    var image_holder = $("<div class=''></div>")
    var image_upload = $("<a class='btn small-file-upload btn-small' href='javascript:;'><span>");
    image_holder.append(image_upload);

    if(image){
        image_holder.append(buildPriceListImage(image));
    }
    entry_control.append(image_holder);

    return entry_control;
}

function buildPriceListImage(image){
    var el = $('<span></span>');
    el.append("<img src='" + image + "' />");
    el.append("<a class='btn btn-small' href='#'>&times;</a> ");

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
