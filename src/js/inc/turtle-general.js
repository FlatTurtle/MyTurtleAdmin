/**
 * Pane switcher for left side of the screen
 */
$('#pane-selector li').on('click', function(e){
    var selected = $(this).attr('id').split('_')[1];
    if(!$(this).hasClass('active')){
        $('#pane-selector li').removeClass('active');
        $(this).addClass('active');
        $('.turtle-area').fadeOut(0);
        $('#pane_' + selected).fadeIn();
    }
});