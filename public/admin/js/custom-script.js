$(function() {
	window.csrf_token = csrfToken();
	
    $('#flash').delay(6000).fadeOut('slow', function() {
        $('#flash').remove();
    });
	
	function csrfToken() {
		return $('meta[name="csrf-token"]').attr('content');
	}
});
