(function($){

	$(document).ready(function() {

		$(document).on('click', '.bp-block-btn-js', function(event) {

			event.preventDefault();

			var $_this = $(this);
			var id_attrs = $_this.attr('id').split('-');
			var to_do = id_attrs[0];
			var blocking_user_id = id_attrs[1];
			var blocked_user_id = id_attrs[2];

			var data = {
		        'action': 'bp_block_script_callback',
		        'to_do': to_do,
		        'blocking_user_id': blocking_user_id,
		        'blocked_user_id': blocked_user_id
		    };

		    $.post(bp_block_ajax_script.ajax_url, data, function(response) {
		        console.log('Got this from the server: ' + response);
		    });

		});

	});

})(jQuery);