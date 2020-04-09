<?php

class BP_Block_Core {

	private static $_instance = null;

	public static function get_instance() {

		if(static::$_instance === null) {
			static::$_instance = new BP_Block_Core();
		}
		
		return static::$_instance;

	}

	private function __construct() {

		add_action('wp_ajax_bp_block_script_callback', [$this, 'handle_ajax_call']);

	}

	public function handle_ajax_call() {

		$response = 'error';

		if(
			isset($_POST['action']) && $_POST['action'] == 'bp_block_script_callback' &&
			isset($_POST['to_do']) && $_POST['to_do'] &&
			isset($_POST['blocking_user_id']) &&  $_POST['blocking_user_id'] &&
			isset($_POST['blocked_user_id']) && $_POST['blocked_user_id']
		) {
			extract($_POST);
			$result = bp_block_add_log($blocking_user_id, $blocked_user_id, $to_do, '');
			if($result) {
				$response = 'success';
			}
		}

		echo $response;
	    wp_die();
	}

	public static function can_block($blocking_user_id) {

		return true;

	}

	public static function is_blocking($blocking_user_id, $blocked_user_id) {

		return false;

	}

}