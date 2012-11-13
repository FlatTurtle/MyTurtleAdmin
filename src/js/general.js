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
				content = content.replace('{{type}}', dragged.attr('id'));
				content = content.replace('{{location}}', '');
				var turtle = $(content);
				turtle.hide();

				droppable.append(turtle);
				bind_event_to_turtles();
				turtle.slideDown(400);
				
				$('.turtle-area').animate({
					borderColor:'#0779bd'
				},100).animate({
					borderColor:'#000'
				},600);
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
						bind_event_to_turtles();
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
$(".turtle-area.sortable").sortable({
	update: function(event,ui){
		var order = $(".turtle-area.sortable").sortable('toArray');
		var pathname = window.location.pathname;
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
});

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
	
	$('.turtle_instance .turtle_save').off().on('click',function(e){
		e.preventDefault();
		var turtle_instance = $(this).parents('.turtle_instance');
		var button = $(this);

		if(button.attr('disabled') != 'disabled'){
			button.attr('disabled', 'disabled').addClass('disable');
			$('.loading', turtle_instance).animate({'opacity': 1}, 200);
			var pathname = window.location.pathname;
			var turtle_id = turtle_instance.attr('id').split('_')[1];
			var option_data = new Object();
			var inputs = $('form :input',turtle_instance);
			inputs.each(function(){
				var option_name = $(this).attr('name').split(turtle_id + '-')[1];
				option_data[option_name] = $(this).val();
			});
			console.debug(option_data);

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
}
bind_event_to_turtles();