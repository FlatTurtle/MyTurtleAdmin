var PANE_DELAY = 3000;

/**
 * Delete a pane
 */
$('.delete_pane').on('click', function(e){
    e.preventDefault();

    // Get pane ID
    var delID = $(this).attr('id').split('_')[2];

    if(confirm($(this).attr('data-confirm'))){
        // Show modal for delay
        var options = {};
        // Non-clickable backdrop
        options.backdrop = "static";
        $('.deleting_pane_modal').modal(options);

        var path = pathname;
        var split = pathname.split("right");
        if(split.length > 1){
            path = split[0] ;
        }

        // Actually delete the pane
        $.ajax({
            url: path + "right/delete/" + delID,
            type: 'GET',
            success: function( data ) {
                setTimeout(function(){
                    location = path + "right/";
                }, PANE_DELAY);
            },
            error: function(data, status){
                $('.deleting_pane_modal').modal('hide');
                alert(lang['error_delete_pane'] + ": "  + status);
            }
        });
    }
});