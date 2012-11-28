var pathname = window.location.pathname;

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
		var turtle_type = dragged.attr('id');
		var pane_id = droppable.attr('id').split('_')[1];

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

				droppable.prepend(turtle);
				bind_event_to_turtles();
				turtle.slideDown(400);

				// Animation when turtle has been added successfull
				$('.turtle-area').animate({
					borderColor:'#0779bd'
				},100).animate({
					borderColor:'#000'
				},600);


				$(".turtle-area.sortable").sortable('refresh');
				sort_turtles();
			},
			error: function(error, status){
				alert('Could not create turtle: ' + status);
			}
		});
	}
});

// Turtle sorting
$(".turtle-area.sortable").sortable({
	update: sort_turtles
});
function sort_turtles(){
	var order = $(".turtle-area.sortable").sortable('toArray');

	for(var i=0; i<order.length; i++) {
		order[i] = order[i].split("_")[1];
	}

	$.ajax({
		url: pathname + '/sort',
		type: 'POST',
		data: {
			order: order
		}

	});
}


// Events to bind to turtles
function bind_event_to_turtles(){

	// Autocomplete De Lijn
	$(".delijn-location").autocomplete({
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

	// Collapsable turtles
	$('.turtle_instance .title').off().on('click',function(){
		$('.autocomplete').autocomplete('close');
		$('.edit_area', $(this).parent()).slideToggle(200);
	});

	// Save turtle options
	$('.turtle_instance form').off().on('submit',function(e){
		e.preventDefault();
		$('.turtle_save', $(this)).click();
	});
	$('.turtle_instance .turtle_save').off().on('click',function(e){
		e.preventDefault();
		var turtle_instance = $(this).parents('.turtle_instance');
		var button = $(this);

		if(button.attr('disabled') != 'disabled'){
			button.attr('disabled', 'disabled').addClass('disable');
			$('.loading', turtle_instance).animate({'opacity': 1}, 200);
			var turtle_id = turtle_instance.attr('id').split('_')[1];
			var option_data = new Object();
			var inputs = $('form :input',turtle_instance);
			inputs.each(function(){
				var option_name = $(this).attr('name').split(turtle_id + '-')[1];
				option_data[option_name] = $(this).val();
			});

			$.ajax({
				url: pathname + '/update',
				type: 'POST',
				data: {
					id: turtle_id,
					options: option_data
				},
				success: function( data ) {
					$('.loading', turtle_instance).animate({'opacity':0}, 200);
					button.removeAttr('disabled').removeClass('disable');
				},
				error: function(data, status){
					alert('Could not save at this moment: ' + status);
					$('.loading', turtle_instance).animate({'opacity':0}, 200);
					button.removeAttr('disabled').removeClass('disable');
				}
			});
		}
	});

	// Delete turtles
	$('.turtle_instance .delete').off().on('click',function(e){
		e.preventDefault();
		if(confirm('Are you sure you want tot delete this turtle?')){
			var turtle_instance = $(this).parents('.turtle_instance');
			var turtle_id = turtle_instance.attr('id').split('_')[1];

			$(this).off();
			$.ajax({
				url: pathname + '/delete',
				type: 'POST',
				data: {
					id: turtle_id
				},
				success: function( data ) {
					turtle_instance.slideUp(300, function(){
						turtle_instance.remove();
					});
				},
				error: function(data, status){
					alert('Could not delete the turtle at this moment: ' + status);
				}
			});
		}
	});
}
bind_event_to_turtles();

// Help Popovers
$(".help-popover").popover();