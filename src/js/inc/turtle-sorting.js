/**
 * Turtle sorting
 */
var sortableIn = 0;
$(".turtle-area.sortable").sortable({
    cursor: 'pointer',
    update: sort_turtles,
    distance: 8,
    receive: function(event, ui){
        if(sortableIn == 1){
            var dragged =  ui.item;
            var droppable = $(this);
            var pane_id = droppable.attr('id').split('_')[1];
            if(current_pane_id > 0){
                droppable = $("#pane_" + current_pane_id + ".turtle-area");
                pane_id = current_pane_id;
            }
            var turtle_type = dragged.attr('id');
            $('.turtle', droppable).html("<div style='padding:20px;'><i class='loading'></i> Adding turtle </div>");

            $.ajax({
                url: pathname + '/create',
                dataType: 'html',
                type: 'POST',
                data:{
                    type: turtle_type,
                    pane: pane_id
                },
                success: function(content){
                    var turtle = $(content);
                    turtle.hide();

                    $('.turtle', droppable).replaceWith(turtle);

                    bind_event_to_turtles();
                    turtle.slideDown(400);

                    // Force re-sort
                    $(".turtle-area.sortable").sortable('refresh');
                    var event = new Object();
                    event.target = droppable[0];
                    sort_turtles(event);
                },
                error: function(error, status){
                    alert('Could not create turtle: ' + status);
                }
            });
        }
    },
    over: function(event, ui)
    {
        sortableIn = 1;
    },
    out: function(event, ui)
    {
        sortableIn = 0;
    }
});

/**
 * Post the new order on change
 */
function sort_turtles(event, ui){
    var order = $(event.target).sortable('toArray');

    for(var i=0; i<order.length; i++) {
        order[i] = order[i].split("_")[1];
        if(isNaN(parseInt(order[i], 10))){
            return;
        }
    }

    $.ajax({
        url: pathname + '/sort',
        type: 'POST',
        data: {
            order: order
        }
    });
}