<?php

/**
 * @author Marcio Figueredo
 * @copyright Copyright (c) 2026
 */

class AF_Bd_Mysql extends AF_Bd {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function get_Instance(){
		return Mysql::get_Instance();
	}

}
?>