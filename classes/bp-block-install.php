<?php

class BP_Block_Install {

	private static $_instance = null;
	
	public static function get_instance() {

		if(static::$_instance === null) {
			static::$_instance = new self();
		}

		return static::$_instance;
	}

	private function __construct() {	

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$this->create_blocking_logs_table();

	}

	public function create_blocking_logs_table() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$bp_prefix       = bp_core_get_table_prefix();

		$sql = "CREATE TABLE IF NOT EXISTS {$bp_prefix}bp_blocking_logs (
					id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					blocking_user_id bigint(20) NOT NULL,
					blocked_user_id bigint(20) NOT NULL,
					blocking_operation varchar(10) NOT NULL,
					blocking_reason text NULL,
					blocking_datetime datetime NOT NULL
				) {$charset_collate};";

		dbDelta($sql);

	}

}