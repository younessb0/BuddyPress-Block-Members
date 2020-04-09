<?php

class BP_Block_Run {

	public static function run() {

		bp_block_install();
		bp_block_core();
		bp_block_admin();
		bp_block_front();
		
	}

}