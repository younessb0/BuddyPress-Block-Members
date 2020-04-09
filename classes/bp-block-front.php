<?php

class BP_Block_Front {

	private static $_instance = null;

	public static function get_instance() {

		if(static::$_instance === null) {
			static::$_instance = new BP_Block_Front();
		}
		
		return static::$_instance;

	}
	
	private function __construct() {

		add_action('wp_enqueue_scripts', [$this, 'load_bp_block_js_script']);
		add_action('bp_member_header_actions', [$this, 'bp_block_add_profile_block_button']);
		add_action('bp_directory_members_actions', [$this, 'bp_block_add_listing_block_button']);
		
	}

	public function load_bp_block_js_script() {

		if(bp_block_is_user_page() || bp_block_is_members_page()) {

			wp_enqueue_script('bp-block-js', BP_BLOCK_URL . 'js/bp-block-script.js', ['jquery']);
    		wp_localize_script('bp-block-js', 'bp_block_ajax_script', ['ajax_url' => admin_url('admin-ajax.php')]);

		}

	}

	public function bp_block_add_profile_block_button() {
		
		if (bp_is_my_profile()) {
			return;
		}		

		bp_block_add_block_button();

	}

	public function bp_block_add_listing_block_button() {

		global $members_template;

		if ($members_template->member->id == bp_loggedin_user_id()) {
			return;
		}

		bp_block_add_block_button(['blocked_user_id' => $members_template->member->id]);

	}

}