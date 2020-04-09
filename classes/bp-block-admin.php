<?php

class BP_Block_Admin {

	private $admin_page_id = 'bp-block-options';
	private $default_tab = 'blocked-users';

	private static $_instance = null;

	public static function get_instance() {
		if(static::$_instance === null) {
			static::$_instance = new self();
		}
		return static::$_instance;
	}
	
	private function __construct() {
		add_action('admin_menu', [$this, 'add_bp_block_to_admin_menu']);
		add_action('bp_block_admin_page_tabs', [$this, 'display_bp_block_admin_page_tabs']);
		add_action('bp_block_admin_page_content', [$this, 'display_bp_block_admin_page_content']);
	}

	private function get_admin_pages() {
		return [
			'blocked-users' 		=> 'Blocked Users',
			'blocking-logs' 		=> 'Blocking Logs',
			'global-restrictions' 	=> 'Global Restrictions',
			'blocked-restrictions' 	=> 'Blocked Users Restrictions',
			'options' 				=> 'Options'
		];
	}

	private function get_admin_tabs() {
		$tabs = [];
		$admin_tabs = $this->get_admin_pages();
		$current_tab = $this->get_current_tab();
		foreach($admin_tabs as $id => $title) {
			$active_class = ($current_tab == $id) ? 'nav-tab-active' : '';
			$tabs[] = [
				'title' => $title,
				'active_class' => $active_class,
				'link' => $this->get_tab_link($id)
			];
		}
		return $tabs;
	}

	private function get_tab_link($tab_id) {
		return admin_url('options-general.php?page=' . $this->admin_page_id . '&tab=' . $tab_id);
	}

	private function get_current_tab() {
		$current_tab = isset($_GET['tab']) && $_GET['tab'] ? $_GET['tab'] : $this->default_tab;
		if(!in_array($current_tab, array_keys($this->get_admin_pages()))) {
			$current_tab = $this->default_tab;
		}
		return $current_tab;
	}

	private function get_current_admin_page() {
		$page = [];
		$admin_pages = $this->get_admin_pages();
		$current_tab = $this->get_current_tab();
		foreach($admin_pages as $id => $title) {
			if($current_tab == $id) {
				$path = BP_BLOCK_DIR . '/templates/admin/partials/'. $id .'.php';
				$page = [
					'title' => $title,
					'path' => $path,
				];
				break;
			}
		}
		return $page;
	}

	public function add_bp_block_to_admin_menu() {
		add_options_page(
			'BuddyPress Block Members', 
			'BuddyPress Block Members', 
			'manage_options' , 
			$this->admin_page_id, 
			[$this, 'display_bp_block_admin_page']
		);
	}

	public function display_bp_block_admin_page() {
		include(BP_BLOCK_DIR . '/templates/admin/bp-block-admin-page.php');
	}

	public function display_bp_block_admin_page_tabs() {
		$tabs = $this->get_admin_tabs();
		include(BP_BLOCK_DIR . '/templates/admin/bp-block-admin-page-tabs.php');
	}

	public function display_bp_block_admin_page_content() {
		$page = $this->get_current_admin_page();
		include (BP_BLOCK_DIR . '/templates/admin/bp-block-admin-page-content.php');
	}

}