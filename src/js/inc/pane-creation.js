/**
 * Add a pane with checkbox selection
 */
$('input.add_pane').on('change', function(){

    // Get pane type
    var type = $(this).attr('id').split('_')[2];

    // Show modal for delay
    var options = {};
    // Non-clickable backdrop
    options.backdrop = "static";
    $('.adding_pane_modal').modal(options);

    var path = pathname;
    var split = pathname.split("right");
    if(split.length > 1){
        path = split[0] ;
    }

    // Actually add the pane
    $.ajax({
        url: path + "right/add/" + type,
        type: 'GET',
        success: function( data ) {
            console.log(data);
            setTimeout(function(){
                location = path + "right/" + data.template + "/" + data.id + "#config";
            }, PANE_DELAY);
        },
        error: function(data, status){
            $('.adding_pane_modal').modal('hide');
            alert(lang['error_add_pane'] + ": "  + status);
        }
    });
});