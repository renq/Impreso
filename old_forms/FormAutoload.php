<?php


final class AF_FormAutoload {
	
	static public function register() {
		spl_autoload_register(array('AF_FormAutoload', 'elements'));
		spl_autoload_register(array('AF_FormAutoload', 'validators'));
		spl_autoload_register(array('AF_FormAutoload', 'layouts'));
		spl_autoload_register(array('AF_FormAutoload', 'exceptions'));
	}
	
	
	static public function elements($class) {
		if (preg_match('/^AF\_([^\s]{0,}Element)$/', $class, $match)) {
			$file = dirname(__FILE__) . "/elements/{$match[1]}.php";
			if (file_exists($file)) {
				include($file);
				return true;
			}
		}
		return false;
	}
	
	
	static public function validators($class) {
		if (preg_match('/^AF\_([^\s]{0,}Validator)$/', $class, $match)) {
			$file = dirname(__FILE__) . "/validators/{$match[1]}.php";
			if (file_exists($file)) {
				include($file);
				return true;
			}
		}
		return false;
	}
	
	
	static public function exceptions($class) {
		if (preg_match('/^AF\_([^\s]{0,}Exception)$/', $class, $match)) {
			$file = dirname(__FILE__) . "/exceptions/{$match[1]}.php";
			if (file_exists($file)) {
				include($file);
				return true;
			}
		}
		return false;
	}
	
	
	static public function layouts($class) {
		if (preg_match('/^AF\_([^\s]{0,}Layout)$/', $class, $match)) {
			$file = dirname(__FILE__) . "/layouts/{$match[1]}.php";
			if (file_exists($file)) {
				include($file);
				return true;
			}
		}
		return false;
	}

	
}


AF_FormAutoload::register();


?>