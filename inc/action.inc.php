<?php
/*
	toctok
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 830 $

	Copyright (C) No Parking 2013 - 2013
*/


class Toctok_Action {
	public $name;
	public $source;
	public $effect;
	
	private $configuration;
	
	function __construct($name, $filepath = null) {
		$this->name = $name;
		$this->source = array(
			'type' => "file",
			'name' => "",
			'trigger' => "",
		);
		$this->effect = array(
			'type' => "file",
			'name' => "",
		);
		$this->configuration($filepath);
	}
	
	function configuration($filepath = null) {
		if ($filepath !== null) {
			$this->configuration = $filepath;
		} else {
			$this->configuration = __DIR__."/../configuration/toctok.json";
		}
		return $filepath;
	}

	function load_configuration() {
		foreach (json_decode(file_get_contents($this->configuration), true) as $name => $elements) {
			if ($name == $this->name) {
				foreach ($elements as $key => $values) {
					$this->{$key} = $values;
				}
			}
		}
	}
	
	function save() {
		if (!file_exists($this->configuration)) {
			file_put_contents($this->configuration, "");
		}
		$actions = json_decode(file_get_contents($this->configuration), true);
		$actions[$this->name] = array('source' => $this->source, 'effect' => $this->effect);
		return file_put_contents($this->configuration, json_encode($actions));
	}
	
	function load() {
		$actions = json_decode(file_get_contents($this->configuration), true);
		if (isset($actions[$this->name])) {
			$this->fill($actions[$this->name]);
		}
	}
	
	function fill($hash) {
		$this->name = isset($hash['name']) ? $hash['name'] : "";
		$this->source['type'] = isset($hash['source']['type']) ? $hash['source']['type'] : "";
		$this->source['name'] = isset($hash['source']['name']) ? $hash['source']['name'] : "";
		$this->source['trigger'] = isset($hash['source']['trigger']) ? $hash['source']['trigger'] : "";
		$this->effect['type'] = isset($hash['effect']['type']) ? $hash['effect']['type'] : "";
		$this->effect['name'] = isset($hash['effect']['name']) ? $hash['effect']['name'] : "";
	}
}
