<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/


class Toctok_Actions implements iterator, countable, arrayAccess {
	protected $instances = array();
	
	private $configuration;
	private $instance;
	
	function __construct($filepath = null, $instance = null) {
		if ($instance == null) {
			$this->instance = "Toctok_Action";
		} else {
			$this->instance = $instance;
		}
		$this->configuration($filepath);
		$this->load_configuration();
	}
	
	function configuration($filepath = null) {
		if ($filepath !== null) {
			$this->configuration = $filepath;
		} else {
			$this->configuration = __DIR__."/../configuration/toctok.json";
		}
		return $this->configuration;
	}
	
	function load_configuration() {
		foreach (json_decode(file_get_contents($this->configuration), true) as $name => $elements) {
			$action = new $this->instance($name);
			foreach ($elements as $key => $values) {
				$action->{$key} = $values;
			}
			$this[] = $action;
		}
	}
	
	function getIterator() {
		return new arrayIterator($this->instances);
	}

	function count() {
		return sizeof($this->instances);
	}

	function offsetGet($offset) {
		return !isset($this[$offset]) ? null : $this->instances[$offset];
	}

	function offsetSet($offset, $value) {
		if ($offset === null) {
			$offset = count($this);
		}
		$this->instances[$offset] = $value;
	}

	function offsetExists($offset) {
		return isset($this->instances[$offset]);
	}

	function offsetUnset($offset) {
		if (isset($this->instances[$offset])) {
			unset($this->instances[$offset]);
		}
	}

	function reset() {
		$this->instances = array();
		return $this;
	}
	
	function current() {
		return current($this->instances);
	}
	
	function rewind() {
		reset($this->instances);
		return $this;
	}
	
	function next() {
		next($this->instances);
		return $this;
	}
	
	function key() {
		return key($this->instances);
	}
	
	function valid() {
		return (key($this->instances) !== null) ? true : false;
	}
	
	function end() {
		return end($this->instances);
	}
}
