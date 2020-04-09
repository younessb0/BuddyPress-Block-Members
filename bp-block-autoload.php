<?php

class BP_Block_Autoload {
	
	public static function autoload() {

		spl_autoload_register(function ($class_name) {
			$class_name = strtolower(str_replace('_', '-', $class_name));
			$class_file = BP_BLOCK_DIR . '/classes/' . $class_name . '.php';
			if(file_exists($class_file)) {
				include $class_file;
			}
		});

	}

}

BP_Block_Autoload::autoload();