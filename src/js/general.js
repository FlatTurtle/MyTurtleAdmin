// Get the URI
var pathname = window.location.pathname;

/**
 * Convert a string to camelcase
 */
String.prototype.camelcase = function() {
    return this.replace(/(\w)(\w*)/g, function(g0,g1,g2){
        return g1.toUpperCase() + g2.toLowerCase();
    });
}

/**
 * Turtle sorting
 */
var sortableIn = 0;
$(".turtle-area.sortable").sortable({
	cursor: 'pointer',
	update: sort_turtles,
	receive: function(event, ui){
		if(sortableIn == 1){
			var dragged =  ui.item;
			var droppable = $(this);
			var turtle_type = dragged.attr('id');
			var pane_id = droppable.attr('id').split('_')[1];
			$('.turtle',droppable).html("<div style='padding:20px;'><i class='loading'></i> Adding turtle </div>");

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

					$('.turtle',droppable).replaceWith(turtle);

					bind_event_to_turtles();
					turtle.slideDown(400);

					// Force re-sort
					$(".turtle-area.sortable").sortable('refresh');
					sort_turtles();
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

/**
 * Creating new turtles by drag and drop
 */
$(".turtle-chooser .draggable" ).draggable({
	revert: true,
	helper: function(event) {
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


/**
 * Bind events to (new) turtles
 */
function bind_event_to_turtles(){

	// Autocomplete De Lijn
	$(".delijn-location").off().on('keydown.autocomplete', function(){
		$(this).autocomplete({
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
	});

	// Autocomplete NMBS
	$(".nmbs-location").off().on('keydown.autocomplete', function(){
		$(this).autocomplete({
			minLength: 3,
			source: function( request, response ) {
				$.ajax({
					url: "http://data.irail.be/NMBS/Stations.json",
					type: 'GET',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						var pattern = new RegExp(request.term.toLowerCase());
						response( $.map( data.Stations, function( item ) {
							if(item.name.toLowerCase().match(pattern)){
								return {
									label: item.name,
									value: item.name
								}
							}
						}));
					}
				});
			}
		});
	});

	// Autocomplete MIVB
	$(".mivb-location").off().on('keydown.autocomplete', function(){
		$(this).autocomplete({
			minLength: 3,
			source: function( request, response ) {
				$.ajax({
					url: "http://data.irail.be/MIVBSTIB/Stations.json",
					type: 'GET',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						var pattern = new RegExp(request.term.toLowerCase());
						response( $.map( data.Stations, function( item ) {
							if(item.name.toLowerCase().match(pattern)){
								return {
									label: item.name.camelcase(),
									value: item.name.camelcase()
								}
							}
						}));
					}
				});
			}
		});
	});


	// Autocomplete Velo
	$(".velo-name").off().on('keydown.autocomplete', function(){
		var self = $(this);
		$(this).autocomplete({
			minLength: 3,
			autoFocus: true,
			autoSelect: true,
			source: function( request, response ) {
				$.ajax({
					url: "http://data.irail.be/Bikes/Velo.json",
					type: 'GET',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						var pattern = new RegExp(request.term.toLowerCase());
						response( $.map( data.Velo, function( item ) {
							if(item.name.toLowerCase().match(pattern)){
								return {
									label: item.name,
									value: item.name,
									location: item.latitude + ',' + item.longitude
								}
							}
						}));
					}
				});
			},
			select: function(e, ui){
				$('.velo-location',self.parents('.turtle_instance')).val(ui.item.location);
			},
			change: function(e, ui){
				if ( !ui.item ) {
					self.val('');
				}
			}
		});
	});

	// Autocomplete Villo
	$(".villo-name").off().on('keydown.autocomplete', function(){
		var self = $(this);
		$(this).autocomplete({
			minLength: 3,
			autoFocus: true,
			autoSelect: true,
			source: function( request, response ) {
				$.ajax({
					url: "http://data.irail.be/Bikes/Villo.json",
					type: 'GET',
					dataType: "json",
					data: {
						name: request.term
					},
					success: function( data ) {
						var pattern = new RegExp(request.term.toLowerCase());
						response( $.map( data.Villo, function( item ) {
							item.name = item.name.toLowerCase();
							var name = item.name.match(/^[0-9]+\s*-\s*((.*?)(?:[\/|:](.*))?)$/);
							console.log(name);
							if(name[1].match(pattern)){
								return {
									label: name[1].camelcase(),
									value: name[1].camelcase(),
									location: item.latitude + ',' + item.longitude
								}
							}
						}));
					}
				});
			},
			select: function(e, ui){
				$('.villo-location',self.parents('.turtle_instance')).val(ui.item.location);
			},
			change: function(e, ui){
				if ( !ui.item ) {
					self.val('');
				}
			}
		});
	});

	// Collapsable turtles
	$('.turtle_instance .title').off().on('click',function(){
		try{$('.autocomplete').autocomplete('close');}catch(e){}
		$('.edit_area', $(this).parent()).slideToggle(200);
	});

	// Save turtle options
	$('.turtle_instance form').off().on('submit',function(e){
		e.preventDefault();
		$('.turtle_save', $(this)).click();
	});
	$('.turtle_instance .turtle_save').off().on('click',function(e){
		e.preventDefault();
		$(this).focus();
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
				if(option_name){
					option_data[option_name] = $(this).val();
				}
			});

			// Resolve MapBox location to geocode first
			if(turtle_instance.hasClass('turtle_mapbox')){
				$.ajax({
					url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+ encodeURIComponent(option_data['name']) +'&sensor=false',
					type: 'GET',
					success: function( data ) {
						if(data.results.length > 0){
							var geocode_el = data.results[0].geometry.location;
							if(typeof geocode_el !='undefined'){
								option_data['location'] = geocode_el.lat + "," + geocode_el.lng;
								updateTurtle(turtle_instance, button, turtle_id, option_data);
							}
						}else{
							alert("Couldn't resolve that address to geocode. Correct the address and try again.");
							$('.loading', turtle_instance).animate({'opacity':0}, 200);
							button.removeAttr('disabled').removeClass('disable');
						}
					},
					error: function(data, status){
						alert('Could not resolve that address to geocode, try to correct the address.');
						$('.loading', turtle_instance).animate({'opacity':0}, 200);
						button.removeAttr('disabled').removeClass('disable');
					}
				});
			}else{
				updateTurtle(turtle_instance, button, turtle_id, option_data);
			}
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

	// RSS turtle selector
	$('.turtle_rss .rss-feed-type').off().on('change', function(e){
		var turtle =  $(e.target).parents('.turtle_rss');
		var value = $(e.target).val();
		if(value == 'custom'){
			$('.rss-feed', turtle).val('').fadeIn();
		}else{
			$('.rss-feed', turtle).hide().val(value);
		}
	});
}

// Turtle update ajax request
function updateTurtle(turtle_instance, button, turtle_id, option_data){
	var path = pathname;
	var split = pathname.split("right");
	if(split.length > 1){
		path = split[0] + "left";
	}

	$.ajax({
		url: path + '/update',
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


// Bind events for existing turtles
bind_event_to_turtles();

// Help Popovers
$(".help-popover").popover();

// Color picker
if($('#inputColor')[0]){
	$('#inputColor').spectrum({
		showInput: true
	});
}

/**
 * Better file uploads
 */
$('input.better-file-upload').change(function() {
   $('input.file-value', $(this).next()).val($(this).val());
});
$('.file-value').on('click', function(){
	$(this).parent().prev('input.better-file-upload').click();
});
$('.file-button').on('click', function(){
	$(this).parent().prev('input.better-file-upload').click();
});

/**
 *
 */
$('#inputFooterMessage').hide();
$('#inputFooterUpdates').hide();
$('#footerType').on('change', function(){
	$('#inputFooterMessage').hide();
	$('#inputFooterUpdates').hide();
	$('#inputFooter' + $(this).val().charAt(0).toUpperCase() + $(this).val().slice(1)).show();
});

$('.shown').show();