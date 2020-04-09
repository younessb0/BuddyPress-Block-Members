<?php

class BP_Block_Logs {

	private static $table = 'bp_blocking_logs';

	public static function add_log($blocking_user_id, $blocked_user_id, $blocking_operation, $blocking_reason = '') {

		global $wpdb;

		$bp_prefix = bp_core_get_table_prefix();

		$table = $bp_prefix . self::$table;
		
		$data = [
			'blocking_user_id' => $blocking_user_id,
			'blocked_user_id' => $blocked_user_id,
			'blocking_operation' => $blocking_operation,
			'blocking_reason' => $blocking_reason,
			'blocking_datetime' => current_time('Y-m-d H:i:s'),
		];


		$result = $wpdb->insert($table, $data);

		return $result;

	}

	public static function get_logs() {

		global $wpdb;

		$bp_prefix = bp_core_get_table_prefix();

		$table = $bp_prefix . self::$table;

		$select = "SELECT * FROM " . $table;

		$results = $wpdb->get_results($select);

		return $results;

	}

}