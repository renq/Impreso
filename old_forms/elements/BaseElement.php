<?php


abstract class AF_BaseElement {


	private $validAttributes = array();

	private $attributes = array();

	private $name;



	/**
	 * The constructor.
	 *
	 */
	public function __construct() {
		$this->setValidAttributes(array(
			'id', 'class', 'title', 'style', 'dir', 'lang', 'xml:lang',
			'onclick', 'ondblclick', 'onmousedown', 'onmouseup', 'onmouseover', 'onmousemove',
			'onmouseout', 'onkeypress', 'onkeydown', 'onkeyup'
		));
	}


	/**
	 * Set valid html attributes for this specific HTML element.
	 *
	 * @param array $list array of string
	 * @return boolean true if ok
	 */
	public function setValidAttributes($list) {
		if (is_array($list)) {
			$this->validAttributes = $list;
			return true;
		}
		return false;
	}


	/**
	 * Return array of valid element attributes.
	 *
	 * @return array of string
	 */
	public function getValidAttributes() {
		return $this->validAttributes;
	}


	/**
	 * Check if $attribute is valid
	 *
	 * @param string $attribute
	 * @return boolean
	 */
	public function isValidAttribute($attribute) {
		return in_array($attribute, $this->validAttributes);
	}


	/**
	 * Set value for attribute
	 *
	 * @param string $attribute
	 * @param string $value
	 */
	public function set($attribute, $value) {
		if (in_array($attribute, $this->validAttributes) || strpos($attribute, 'data-') === 0) {
			$this->attributes[$attribute] = $value;
			return $this;
		}
		else {
			throw new AF_UndefinedAttributeException();
		}
	}


	/**
	 *
	 * @see forms/elements/BaseElement#set()
	 *
	 */
	public function __set($attribute, $value) {
		return $this->set($attribute, $value);
	}


	/**
	 * Returns value for attribute
	 *
	 * @param string $attribute
	 * @return string
	 */
	public function get($attribute) {
		if (array_key_exists($attribute, $this->attributes)) {
			return $this->attributes[$attribute];
		}
		return '';
	}


	/**
	 *
	 * @see forms/elements/BaseElement#get()
	 *
	 */
	public function __get($attribute) {
		return $this->get($attribute);
	}


	/**
	 * Return values for all attributes.
	 *
	 * @return unknown_type
	 */
	public function getAttributes() {
		return $this->attributes;
	}


	/**
	 * Return element name.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * Set element name.
	 *
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
		$this->set('name', $name);
	}


	/**
	 * @see forms/elements/BaseElement#show()
	 */
	public function __toString() {
		return $this->show();
	}



}


?>