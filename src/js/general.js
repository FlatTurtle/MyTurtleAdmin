/**
 * Message plugin
 */

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

	$.ajax({
		type: 'POST',
		url: pathname + '/plugin/message',
		data: {
			message: $('#the_message').val()
		}
	});
	
	$('#messageModal').modal('hide');
})