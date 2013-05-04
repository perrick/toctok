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

	function save() {
		if (!file_exists($this->configuration)) {
			file_put_contents($this->configuration, "");
		}
		$actions = json_decode(file_get_contents($this->configuration), true);
		$actions[$this->name] = array('source' => $this->source, 'effect' => $this->effect);
		return file_put_contents($this->configuration, json_encode($actions));
	}

	function form() {
		$html = '
			<form action="" method="post">
			<label for="action[name]">'.__("action").'</label>
			<input name="action[name]" value="'.$this->name.'" />
			
			<fieldset>
			<legend>'.__("source").'</legend>
			<label for="action[source][type]">'.__("type").'</label>
			<select name="action[source][type]">
			<option value="file">'.__("file").'</option>
			</select>
			
			<label for="action[source][name]">'.__("name").'</label>
			<input name="action[source][name]" value="'.$this->source['name'].'" />

			<label for="action[source][trigger]">'.__("trigger").'</label>
			<select name="action[source][trigger]">
			<option value="last_modification">'.__("last modification").'</option>
			</select>
			</fieldset>
			
			<fieldset>
			<legend>'.__("effect").'</legend>
			<label for="action[effect][type]">'.__("type").'</label>
			<select name="action[effect][type]">
			<option value="mp3">'.__("mp3").'</option>
			</select>
			
			<label for="action[effect][name]">'.__("file").'</label>
			<input name="action[effect][name]" value="'.$this->effect['name'].'" />
			</fieldset>
			
			<input name="save" type="submit" value="'.__("Save").'" />
			</form>
		';
		
		return $html;
	}
}
