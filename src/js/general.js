// Submit on enter
$('#messageModal input').keypress(function (e) {
	if (e.which == 13) {
		$('#btnSendMessage').click();
	}
});

// Send a message to the screen
$('#btnSendMessage').click(function(e){
	e.preventDefault();
	var pathname = window.location.pathname;
	
	if($('#btnSendMessage').attr('disabled') != 'disabled'){
		$('#btnSendMessage').attr('disabled', 'disabled').addClass('disable');

		$.ajax({
			type: 'POST',
			url: pathname + '/plugin/message',
			data: {
				message: $('#the_message').val()
			},
			success: function(html){
				setTimeout(function() {
					$('#btnToggleClock i').toggleClass('active');
					$('#btnSendMessage').removeAttr('disabled');
				}, 1000);
				$('#messageModal').modal('hide');
				$('#btnSendMessage').removeAttr('disabled').removeClass('disable');
			}
		});
	}
});

// Toggle clock on screen
$('#btnToggleClock').click(function(e){
	e.preventDefault();
	
	if($('#btnToggleClock').attr('disabled') != 'disabled'){
		
		var pathname = window.location.pathname;
		$('#btnToggleClock').attr('disabled', 'disabled').addClass('disable');

		$.ajax({
			type: 'POST',
			url: pathname + '/plugin/clock',
			data: {
				action: (($('#btnToggleClock i').hasClass('active'))? 'off':'on')
			},
			success: function(html){
				setTimeout(function() {
					$('#btnToggleClock i').toggleClass('active');
					$('#btnToggleClock').removeAttr('disabled');
				}, 100);
			}
		});
	}
});

// Toggle screen power
$('#btnToggleScreen').click(function(e){
	e.preventDefault();
	
	if($('#btnToggleScreen').attr('disabled') != 'disabled'){
		
		var pathname = window.location.pathname;
		$('#btnToggleScreen').attr('disabled', 'disabled').addClass('disable');

		$.ajax({
			type: 'POST',
			url: pathname + '/plugin/screen_power',
			data: {
				action: (($('#btnToggleScreen i').hasClass('active'))? 'off':'on')
			},
			success: function(html){
				setTimeout(function() {
					$('#btnToggleScreen i').toggleClass('active').removeClass('icon-eye-close').removeClass('icon-eye-open');
					var end = 'close';
					if($('#btnToggleScreen i').hasClass('active')){
						end ='open';
					}
					$('#btnToggleScreen i').addClass('icon-eye-' + end);
					$('#btnToggleScreen').removeAttr('disabled');
				}, 400);
			}
		});
	}
});

$( ".draggable" ).draggable({ 
	revert: true, 
	stack: ".turtle-chooser .turtle"  
});
$( ".droppable" ).droppable({
	accept: ".turtle",
	drop: function( event, ui ) {
		$( this ).html( "Dropped!" + ui.draggable);
	}
});