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