/**
 * Pane sorting
 */
$(".pane-chooser .sortable").sortable({
    cursor: 'pointer',
    update: sort_panes
});

/**
 * Post the new order on change
 */
function sort_panes(event, ui){
    var order = $(".pane-chooser .sortable").sortable('toArray');

    for(var i=0; i<order.length; i++) {
        order[i] = order[i].split("_")[1];
    }

    var path = "";
    var split = pathname.split("right");
    if(split.length > 1){
        path = split[0] + 'right/sort';
    }

    $.ajax({
        url: path,
        type: 'POST',
        data: {
            order: order
        },
        success: function(){
        },
        error : function(){
        }
    });
}
console.log("test3");
