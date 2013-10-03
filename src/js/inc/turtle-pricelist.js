/**
 * (Re)construct the price list from the given data
 */

function buildPriceList(data, turtle_instance){
    if(data && data != ""){
        var priceData = JSON.parse(data);
        $('#title', turtle_instance).prop('value', priceData.title);
        if(priceData.categories){

            for(var i in priceData.categories){
                var category = priceData.categories[i];
                var categoryHTML = buildPriceListCategory(category.name);

                categoryHTML = buildPriceListCategoryEntries(category, categoryHTML);

                $('.categories', turtle_instance).append(categoryHTML);
            }
        }
    }
    bindPriceListEvents();
}


function buildPriceListCategory(name){
    if(typeof name === 'undefined'){
        name = "";
    }

    var control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" +  lang['turtle_pricelist_category_name'] + "</label>");

    var controls = $("<div class='controls'></div>");
    var input = $("<input type='text' class='input name' placeholder=''/>").val(name);
    controls.append(input);
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

    return categoryHTML;
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

    // control group for 'name' input box and delete button
    var control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" +  lang['turtle_pricelist_category_entry_name'] + "</label>");
    var controls = $("<div class='controls'></div>");
    var input = $("<input type='text' class='input name'/>").val(name);
    controls.append(input);
    controls.append("<button id='delete-item' class='btn btn-small pull-right'><i class='icon-trash'></i></button>");
    control_group.append(controls);
    entry_control.append(control_group);

    // control group for price and image upload
    control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" +  lang['turtle_pricelist_category_entry_price'] + "</label>");
    controls = $("<div class='controls'></div>");
    controls.append("<input type='number' class='input price' step='0.05' pattern='^\\d+(\\.|\\,)\\d{2}$' value='" + price + "'/>");

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
    entry_control.append(control_group);


    control_group = $("<div class='control-group'></div>");
    control_group.append("<label class='control-label'>" +  lang['turtle_pricelist_category_entry_description'] + "</label>");
    controls = $("<div class='controls'></div>");
    controls.append("<textarea rows='2' cols='35' class='styled description'>" + description + "</textarea>");
    control_group.append(controls);
    entry_control.append(control_group);

    return entry_control;
}

function buildPriceListImage(image, turtle_id, id){
    var el = $('<span></span>');
    el.append("<img src='" + image + "' />");
    el.append("<a class='btn btn-small pricelist-image-delete' href='#' data-turtle-id='"+ turtle_id +"' data-id='"+ id + "'>&times;</a> ");

    return el;
}

function savePriceList(turtle_instance){
    var data = {};
    data.title = $('.control-group .controls #title', turtle_instance).val();
    data.categories = [];

    // get categories
    $('.categories .control-group', turtle_instance).each(function(){
        var category = {};
        category.name = $('.name', this).val();
        category.entries = [];

        // get entries
        $('.listing', this).each(function(){
            var entry = {};
            entry.name = $('.name', this).val();
            entry.price = $('.price', this).val();
            entry.description = $('.description', this).val();

            // Save id
            var id = $(this).prop('id').split('-');
            entry.id = id[1];

            //save image url
            if($(this).has('img')){
                entry.image = $('img', $(this)).attr('src');
            }

            if(entry.name.length > 0){
                category.entries.push(entry);
            }
        });

        if(category.name && category.name.length > 0 && category.entries.length > 0){
            data.categories.push(category);
        }
    });

    return JSON.stringify(data);
}

function bindPriceListEvents(){

    // Add category button
    $(".turtle_pricelist #add-category").off().on('click', function(e){
        e.preventDefault();
        var pricelist_turtle = $(this).parents('.turtle_pricelist');

        var category_html = buildPriceListCategory();
        $('.listings', category_html).append(buildPriceListCategoryEntry());

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

            // Remove images
            $('.pricelist_image_delete', component).click();

            component.remove();
        }
    });

    // Remove item entry
    $('.turtle_pricelist #delete-item').off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle_pricelist_delete_item_note'])){
            var component = $(this).parents('.listing');

            // Remove images
            $('.pricelist-image-delete', component).click();


            component.remove();
        }
    });

    // Image upload
    $('.pricelist-image-file').off().on('change', function(e){
        e.preventDefault();

        var formData = new FormData($(this).parents('form')[0]);
        var button = $(this).parents(".small-file-upload");
        var buttonLabel = $('span', button);
        var inputFileEl = $(this);


        if(!button.hasClass('disabled')){
            buttonLabel.html(lang['term_uploading'] + "  ...");
            inputFileEl.attr('disabled', 'disabled');
            button.attr('disabled', 'disabled').addClass('disable');


            var upload_path = pathname;
            var split = pathname.split("right");
            if(split.length > 1){
                upload_path = split[0];
            }
            // check for 'left' because there was no 'right' in path
            else{
                split = pathname.split("left");
                upload_path = split[0]
            }
            upload_path += "menu-image/upload/";

            var turtle_id = $(this).data('turtle-id');
            var id = $(this).data('id');
            var turtle_logo_holder = $(this).parents(".entry_image_holder");

            $.ajax({
                url : upload_path + turtle_id + "/" + id,
                type: 'POST',
                data: formData,
                success : function (response) {
                    if(response){
                        button.removeAttr('disabled').removeClass('disable');
                        inputFileEl.removeAttr('disabled');
                        buttonLabel.html(lang["term_change"] + " " + lang["term_image"].toLowerCase());

                        turtle_logo_holder.append(buildPriceListImage(response, turtle_id, id));
                        bindPriceListEvents();
                    }else{
                        button.removeAttr('disabled').removeClass('disable');
                        inputFileEl.removeAttr('disabled');
                        buttonLabel.html(lang["term_upload"] + " " + lang["term_image"].toLowerCase());
                    }
                },
                error: function (response) {
                    console.log("Pricelist image logo upload error: ");
                    console.log(response);
                    button.removeAttr('disabled').removeClass('disable');
                    inputFileEl.removeAttr('disabled');
                    buttonLabel.html(lang["term_upload"] + " " + lang["term_image"].toLowerCase());
                },
                //Options to tell JQuery not to process data or worry about content-type
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });


    // Image delete
    $('.pricelist-image-delete').off().on('click', function(e){
        e.preventDefault();
        var delete_path = pathname;
        var split = pathname.split("right");
        if(split.length > 1){
            delete_path = split[0];
        }
        // check for 'left' because there was no 'right' in path
        else{
            split = pathname.split("left");
            delete_path = split[0]
        }
        delete_path += "menu-image/delete/";


        var turtle_id = $(this).data('turtle-id');
        var id = $(this).data('id');
        var turtle_logo_holder = $(this).parents(".entry_image_holder");
        var button = $(".small-file-upload", turtle_logo_holder);
        var buttonLabel = $('span', button);

        $.ajax({
            url : delete_path + turtle_id + "/" + id,
            type: 'GET',
            success : function (response) {
                $('img',turtle_logo_holder).remove();
                $('.pricelist-image-delete',turtle_logo_holder).remove();
                buttonLabel.html(lang["term_upload"] + " " + lang["term_image"].toLowerCase());
            },
            error: function (response) {
                console.log("Pricelist image delete error: ");
                console.log(response);
            },
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

bindPriceListEvents();
