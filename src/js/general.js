// Creating new turtles by dragging
$(".turtle-chooser .draggable" ).draggable({
	revert: true,
	stack: ".turtle-chooser .turtle"
});

$( ".turtle-area.droppable").droppable({
	accept: ".turtle",
	drop: function( event, ui ) {
		var dragged =  ui.draggable;
		var droppable = $(this);

		$.ajax({
			url: '../../assets/inc/turtles/options_'+ dragged.attr('id') + '.php',
			dataType: 'html',
			success: function(content){
				content = content.replace('{{title}}', dragged.html());
				content = content.replace('{{location}}', '');
				var turtle = $(content);
				turtle.hide();

				droppable.append(turtle);
				bind_autocomplete();
				turtle.slideDown(400);
			},
			error: function(error){
				$.ajax({
					url: '../../assets/inc/turtles/options_blank.php',
					dataType: 'html',
					success: function(content){
						content = content.replace('{{title}}', dragged.html());
						var turtle = $(content);
						turtle.hide();

						droppable.append(turtle);
						bind_autocomplete();
						turtle.slideDown(400);
					},
					error: function(error){

					}
				});
			}
		});
	}
});

// Turtle sorting
$(".turtle-area.sortable").sortable();

// Autocomplete De Lijn
function bind_autocomplete(){
	$("#delijn-location").autocomplete({
		minLength: 4,
		source: function( request, response ) {
			$.ajax({
				url: "http://data.irail.be/DeLijn/Stations.json",
				type: 'GET',
				dataType: "json",
				data: {
					name: request.term
				},
				success: function( data ) {
					response( $.map( data.Stations, function( item ) {
						return {
							label: item.name,
							value: item.name
						}
					}));
				}
			});
		}
	});
}
bind_autocomplete();