/**
 * General functions and events
 * @author: Michiel Vancoillie (michiel@irail.be)
 */

// Get the current URI
var pathname = window.location.pathname;

// Convert a string to camelcase
String.prototype.camelcase = function() {
    return this.replace(/(\w)(\w*)/g, function(g0,g1,g2){
        return g1.toUpperCase() + g2.toLowerCase();
    });
}

// Color picker
if($('#inputColor')[0]){
    $('#inputColor').spectrum({
        showInput: true
    });
}

// Nicer looking file uploads
$('input.better-file-upload').change(function() {
   $('input.file-value', $(this).next()).val($(this).val());
});
$('.file-value').on('click', function(){
    $(this).parent().prev('input.better-file-upload').click();
});
$('.file-button').on('click', function(){
    $(this).parent().prev('input.better-file-upload').click();
});

// Nicer looking select
$('.niceselect').selectpicker();


// Footer selector functions
$('#inputFooterMessage').hide();
$('#inputFooterUpdates').hide();
$('#footerType').on('change', function(){
    $('.footer-line').removeClass('single');
    $('#inputFooterMessage').hide();
    $('#inputFooterUpdates').hide();
    $('#inputFooter' + $(this).val().charAt(0).toUpperCase() + $(this).val().slice(1)).show();
    if($(this).val() == "none"){
        $('.footer-line').addClass('single');
    }
});

// Force show elements with class shown
$('.shown').show();


// Bootstrap WYSIHTML5
$(document).ready(function(){
    $('.wysihtml5').wysihtml5({
        "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": false, //Button to insert a link. Default true
        "image": false, //Button to insert an image. Default true,
        "color": false //Button to change color of font
    });
});

// More link on homescreen
$('.infoscreens .more').on('click', function(e){
    e.preventDefault();
    var target = $('.infoscreens.inactive');
    if(target.hasClass('hide')){
        target.removeClass('hide');
        $('span', this).html(lang['term_less']);
    }else{
        target.addClass('hide');
        $('span', this).html(lang['term_more']);
    }
});

// Navbar search
$('.navbar .search-query').bind('input', function(){
    var search = $(this).val().trim().toLowerCase();
    var infoscreens = $(".infoscreens");
    var inactive = $(".infoscreens.inactive");

    if(inactive.hasClass('hide')){
        inactive.removeClass('hide').addClass('washidden');
    }

    $(".search-message", infoscreens).html(lang['warn_no_screens_found']).show();
    $(".more", infoscreens).hide();

    if(search.length > 0){
        // Build regexp to search
        var regexp = new RegExp(".*" + search.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&") + ".*");
        $(".screen-link", infoscreens).hide();

        var matched = false;
        // Loop through screens to find ones that match the search term
        $(".screen-link", infoscreens).filter(function() {
            var match = $(this).data("title").match(regexp);
            if(match) matched = true;
            return match;
        }).show();
        if(matched){
            // There was at least one match
            $(".search-message", infoscreens).html(lang['term_searching_for'] + ": <strong>" + search +"</strong>");
        }
    }else{
        // Empty search term, exit search
        $(".search-message", infoscreens).hide();
        $(".screen-link", infoscreens).show();
        $(".more", infoscreens).show();
        if(inactive.hasClass('washidden')){
            inactive.removeClass('washidden');
            inactive.addClass('hide');
        }
    }
});


/**
 * Intro.js
 */

// Only show on pages with help data
if($("*[data-intro]").length > 0){
    $("#help").removeClass("hide");
}

// Help a brother out!
$("#help").on('click', function(e){
    e.preventDefault();
    introJs().start();
})

// Close Intro.js on resize
$(window).resize(function() {
    introJs().exit();
});