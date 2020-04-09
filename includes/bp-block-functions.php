<?php

function bp_block_run() {

	BP_Block_Run::run();

}

function bp_block_install() {

	return BP_Block_Install::get_instance();

}

function bp_block_core() {

	return BP_Block_Core::get_instance();

}

function bp_block_admin() {

	return BP_Block_Admin::get_instance();

}

function bp_block_front() {

	return BP_Block_Front::get_instance();

}

function bp_block_add_block_button($args = []) {

	echo bp_block_get_add_block_button($args);

}

function bp_block_get_add_block_button($args = []) {

	global $bp, $members_template;

	$defaults = [
		'blocking_user_id'  => bp_loggedin_user_id(),
		'blocked_user_id'   => bp_displayed_user_id(),
		'link_text'  		=> '',
		'link_title'    	=> '',
		'wrapper_class' 	=> '',
		'link_class'    	=> '',
		'wrapper'       	=> 'li'
	];
 
	$r = wp_parse_args($args, $defaults);

	if (!$r['blocking_user_id'] || !$r['blocked_user_id']) {
		return false;
	}

	$can_block = bp_block_can_block($r['blocking_user_id']);

	if(!$can_block) {
		return false;
	}

	$is_blocking = bp_block_is_blocking($r['blocking_user_id'], $r['blocked_user_id']);

	// setup some variables
	$id        = 'not-blocking';
	$class     = 'block';
	$link_text = 'Block';

	if ($is_blocking) {
		$id        = 'blocking';
		$class     = 'unblock';
		$link_text = 'Unblock';
	}

	if (empty($r['link_text'])) {
		$r['link_text'] = $link_text;
	}

	$wrapper_class = 'block-button ' . $id;

	if (!empty($r['wrapper_class'])) {
		$wrapper_class .= ' '  . esc_attr($r['wrapper_class']);
	}

	$link_class = $class . ' bp-block-btn-js';

	if (!empty($r['link_class'])) {
		$link_class .= ' '  . esc_attr($r['link_class']);
	}

	// make sure we can view the button if a user is on their own page
	$block_self = empty($members_template->member) ? true : false;

	// if we're using AJAX and a user is on their own profile, we need to set
	// block_self to false so the button shows up
	if ( ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) && bp_is_my_profile() ) {
		$block_self = false;
	}

	$link_id = $class . '-' . (int) $r['blocking_user_id'] . '-' . (int) $r['blocked_user_id'];

	// setup the button arguments
	$button = [
		'id'                => $id,
		'component'         => 'follow',
		'must_be_logged_in' => true,
		'block_self'        => $block_self,
		'wrapper_class'     => $wrapper_class,
		'wrapper_id'        => 'block-button-' . (int) $r['blocking_user_id'],
		'link_href'         => '#',
		'link_text'         => esc_attr( $r['link_text'] ),
		'link_title'        => esc_attr( $r['link_title'] ),
		'link_id'           => $link_id,
		'link_class'        => $link_class,
		'wrapper'           => ! empty( $r['wrapper'] ) ? esc_attr( $r['wrapper'] ) : false
	];

	$block_btn = apply_filters('bp_block_get_add_block_button', $button, $r['blocking_user_id'], $r['blocked_user_id']);

	// return the HTML button
	return bp_get_button($block_btn);

}

function bp_block_can_block($bloking_user_id) {

	return BP_Block_Core::can_block($bloking_user_id);

}

function bp_block_is_blocking($bloking_user_id, $blocked_user_id) {

	return BP_Block_Core::is_blocking($bloking_user_id, $blocked_user_id);

}

function bp_block_is_user_page() {
	return bp_is_user();
}

function bp_block_is_user_profile() {
	return bp_is_user_profile();
}

function bp_block_is_members_page() {
	return bp_current_component() == 'members';
}

function bp_block_add_log($blocking_user_id, $blocked_user_id, $blocking_operation, $blocking_reason) {
	return BP_Block_Logs::add_log($blocking_user_id, $blocked_user_id, $blocking_operation, $blocking_reason);
}

function bp_block_get_logs() {
	return BP_Block_Logs::get_logs();
}