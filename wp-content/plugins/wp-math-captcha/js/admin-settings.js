jQuery(document).ready(function($) {

	// resets options to defaults if needed
	$(document).on('click', '.reset_mc_settings', function() {
		return confirm(mcArgsSettings.resetToDefaults);
	});
});