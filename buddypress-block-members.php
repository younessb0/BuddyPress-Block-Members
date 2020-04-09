<?php

/**
 * Plugin Name: BuddyPress Block Members
 * Description: BuddyPress plugin to block members.
 * Author:      Youness Bouhou
 * Version:     1.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Only load the plugin code if BuddyPress is activated.
 */
function bp_block_init() {

	// Constants
	define('BP_BLOCK_DIR', dirname(__FILE__));
	define('BP_BLOCK_URL', plugin_dir_url(__FILE__));

	// Include autoload for classes
	require(BP_BLOCK_DIR . '/bp-block-autoload.php');

	// Include functions
	require(BP_BLOCK_DIR . '/includes/bp-block-functions.php');

	// Run the plugin
	bp_block_run();

}

add_action('bp_include', 'bp_block_init');