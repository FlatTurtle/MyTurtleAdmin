function buildOffers(data, turtle_instance){
    if(data){
        var offer_data = JSON.parse(data);

        if(offer_data.offers){

            for(var i in offer_data.offers){
                var offer = offer_data.offers[i];

                var offer_html = buildOffer(offer.name, offer.description, offer.price, offer.image, offer.id);

                $('.offer-wrapper', turtle_instance).append(offer_html);
            }

        }
    }
    bindOfferEvents();
}

function buildOffer(name, description, price, image, id){
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
    var turtle_id = $('.turtle_offers').attr('id').split('_');

    var image_upload = $("<a class='btn small-file-upload btn-small' href='javascript:;'>" +
        "<span>" + buttonLabel + "</span>" +
        "<form enctype='multipart/form-data'>" +
        "<input type='file' name='file-"+id+"' class='offer-image-file' data-turtle-id='"+ turtle_id[1] +"' data-id='"+ id + "'>" +
        "</form></a>");
    image_holder.append(image_upload);

    if(image){
        image_holder.append(buildOfferImage(image, turtle_id[1], id));
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

function buildOfferImage(image, turtle_id, id){
    var el = $('<span></span>');
    el.append("<img src='" + image + "' />");
    el.append("<a class='btn btn-small offer-image-delete' href='#' data-turtle-id='"+ turtle_id +"' data-id='"+ id + "'>&times;</a> ");

    return el;
}

function bindOfferEvents(){
    // bind 'add offer' button
    $(".turtle_offers #add-offer").off().on('click', function(e){
        e.preventDefault();

        var turtle =  $(this).parents('.turtle_offers');

        var offer_html = buildOffer();

        $(".offer-wrapper", turtle).append(offer_html);
        bindOfferEvents();
    });

    $(".turtle_offers #delete-offer").off().on('click', function(e){
        e.preventDefault();

        if(confirm(lang['turtle_weekmenu_delete_offer_note'])){
            var component = $(this).parents('.offer');

            // Remove images
            $('.offer-image-delete', component).click();

            component.remove();
        }
    });

    // Image upload
    $(".offer-image-file").off().on('change', function(e){
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
                        bindOfferEvents()
                    }else{
                        button.removeAttr('disabled').removeClass('disable');
                        inputFileEl.removeAttr('disabled');
                        buttonLabel.html(lang["term_upload"] + " " + lang["term_image"].toLowerCase());
                    }
                },
                error: function (response) {
                    console.log("offer image upload error: ");
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
    $(".offer-image-delete").off().on('click', function(e){
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

        console.log(id);
        $.ajax({
            url : delete_path + turtle_id + "/" + id,
            type: 'GET',
            success : function (response) {
                $('img',turtle_logo_holder).remove();
                $('.offer-image-delete',turtle_logo_holder).remove();
                buttonLabel.html(lang["term_upload"] + " " + lang["term_image"].toLowerCase());
            },
            error: function (response) {
                console.log("offer image delete error: ");
                console.log(response);
            },
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

function saveOffers(turtle_instance){
    var data = {};
    data.offers = [];
    $('.offer-wrapper .offer', turtle_instance).each(function(){
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

    return JSON.stringify(data);
}
bindOfferEvents();