function addSpecialDay() {
	var specialDaysContent = $('#special-days-content');

	var row = $('<tr class="special-day"></tr>');
	row.append('<td><input type="text" class="date"/></td>');
	row.append('<td><input type="checkbox"/></td>');
	row.append('<td><input type="text" class="time" placeholder="00:00"></td>');
	row.append('<td><input type="text" class="time" placeholder="00:00"></td>');
	row.append('<td><button class="btn special-days-delete">X</button></td>')

	// activate date and timepicker
	row.find('.time').timepicker({
    					showMeridian: false
    				});
	row.find('.date').datepicker();

	specialDaysContent.append(row);
	registerPowerSettingsEvents();
}

function savePowerSettings() {
	// save data
}

function registerPowerSettingsEvents() {
	// click event for add button
	$('#add-special-day').off().on('click', function(e) {
		e.preventDefault();
		addSpecialDay();
	});

	// click event for save button
	$('#save-power-settings').off().on('click', function(e) {
		e.preventDefault();
		savePowerSettings();
	});

	// click events for deletes
	$('.special-days-delete').off().on('click', function(e){
        e.preventDefault();
        
        var component = $(this).parents('.special-day');
        component.remove();
    });	
}

function initPowerSettings() {
	// do something with the data

	registerPowerSettingsEvents();
	
}


registerPowerSettingsEvents();