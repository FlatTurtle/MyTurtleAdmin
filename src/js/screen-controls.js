/**
 * Screen control buttons
 */

var delayClock = 500;
var delayRefresh = 15000;
var delayPower = 20000;
var alertTimeout = null;

// Submit on enter
$('#messageModal input').keypress(function (e) {
	if (e.which == 13) {
		$('#btnSendMessage').click();
	}
});

// Send a message to the screen
$('#btnSendMessage').click(function(e){
	e.preventDefault();

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
				}, delayClock);
			}
		});
	}
});

// Toggle screen power
$('#btnToggleScreen').click(function(e){
	e.preventDefault();

	if($('#btnToggleScreen').attr('disabled') != 'disabled'){

		$('#btnToggleScreen').attr('disabled', 'disabled').addClass('disable');

        showAlert(lang['screen_message_power'], delayPower);
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
				}, delayPower);
			}
		});
	}
});

// Toggle screen power
$('#btnRefreshScreen').click(function(e){
    e.preventDefault();

    if($('#btnRefreshScreen').attr('disabled') != 'disabled'){

        $('#btnRefreshScreen').attr('disabled', 'disabled').addClass('disable');

        showAlert(lang['screen_message_refresh'], delayPower);
        $.ajax({
            type: 'POST',
            url: pathname + '/plugin/screen_reload',
            success: function(html){
                setTimeout(function() {
                    $('#btnRefreshScreen').removeAttr('disabled');
                }, delayRefresh);
            }
        });
    }
});

/**
 * Show an alert fixed to the bottom of the page
 */
function showAlert(text, duration){
    if(alertTimeout)
        clearTimeout(alertTimeout);

    $(".alert-message").html("<i class='icon-info-sign'></i>&nbsp;&nbsp;&nbsp;"+text);

    $(".alert-message").css('display', 'block').slideDown(0).fadeIn(300);
    alertTimeout = setTimeout(function() {
        $(".alert-message").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, duration);
}