/**
 * Creating new turtles by drag and drop
 */
$(".turtle-chooser .draggable" ).draggable({
    revert: true,
    helper: function(event) {
        // Stylish helper
        helper = $(event.target).clone();
        helper.css('padding','30px');
        helper.css('min-width','100px');
        helper.css('line-height','0px');
        helper.css('display','block');
        return helper;
    },
    stack: ".turtle-chooser .turtle",
    connectToSortable: ".turtle-area.sortable"
});