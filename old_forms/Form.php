<?php

require_once(dirname(__FILE__) . '/FormAutoload.php');


class AF_Form extends AF_FormElement {


	public function __construct() {
		parent::__construct();
	}

	/**
	 *
	 * @param $type
	 * @param $name
	 * @param $label
	 * @param $validators array|AF_Validator
	 * @return AF_FormElement
     * @throws AF_UnknownClassException
	 */
	public function add($type, $name, $label = false, $validators = array()) {
		$class = $type;
		$class[0] = strtoupper($type[0]);
		$class = "AF_{$class}Element";
		if (class_exists($class)) {
			$object = new $class($label, $validators);
			if ($type == 'multipleselect')
				$name .= '[]'; // multipleselect musi być tablicą
			$this->addElement($name, $object);
			if ($type == "file") {
				$this->enctype = 'multipart/form-data';
			}
			return $object;
		}
		else {
			throw new AF_UnknownClassException("Class $class not found!");
		}
	}


	/**
	 *
	 * @param $type
	 * @param $name
	 * @param $label
	 * @param $validators
	 * @return Element
	 */
	public function before($before, $type, $name, $label = false, $validators = array()) {
	    $class = $type;
	    $class[0] = strtoupper($type[0]);
	    $class = "AF_{$class}Element";
	    if (class_exists($class)) {
	        $object = new $class($label, $validators);
	        $this->insertBefore($before, $name, $object);
	        if ($type == "file") {
	            $this->enctype = 'multipart/form-data';
	        }
	        return $object;
	    }
	    else {
	        throw new AF_UnknownClassException("Class $class not found!");
	    }
	}


}

